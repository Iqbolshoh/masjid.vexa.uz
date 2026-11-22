<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Mosque;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the portal landing page with prayer times and active mosques.
     */
    public function index(Request $request)
    {
        $now = Carbon::now('Asia/Bishkek');
        $currentTime = $now->format('H:i');
        
        $selectedDistrict = $request->query('district');
        $search = $request->query('search');

        $districts = District::withCount('mosques')->orderBy('sort_order')->get();

        $query = Mosque::with(['district', 'prayerTimes'])
            ->where('is_verified', true);

        if ($selectedDistrict && $selectedDistrict !== 'all') {
            $query->whereHas('district', function ($q) use ($selectedDistrict) {
                $q->where('slug', $selectedDistrict);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('landmark', 'like', "%{$search}%")
                    ->orWhere('imam_name', 'like', "%{$search}%");
            });
        }

        $mosques = $query->orderBy('district_id')->orderBy('id')->get();

        // Calculate next prayer globally for Osh (reference: Sulaymon-Too or first available mosque)
        $referenceMosque = $mosques->firstWhere('slug', 'sulaymon-too-markaziy-jome-masjidi') ?? $mosques->first();
        $nextPrayerInfo = $this->calculateNextPrayer($referenceMosque?->prayerTimes, $now);

        return view('home', compact(
            'districts',
            'mosques',
            'selectedDistrict',
            'search',
            'now',
            'currentTime',
            'nextPrayerInfo'
        ));
    }

    /**
     * Return JSON data of all mosques for the interactive Leaflet map.
     */
    public function getMosquesApi()
    {
        $now = Carbon::now('Asia/Bishkek');

        $mosques = Mosque::with(['district', 'prayerTimes'])
            ->where('is_verified', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($mosque) use ($now) {
                $next = $this->calculateNextPrayer($mosque->prayerTimes, $now);
                return [
                    'id' => $mosque->id,
                    'name' => $mosque->name,
                    'slug' => $mosque->slug,
                    'district' => $mosque->district->name_uz,
                    'address' => $mosque->address,
                    'phone' => $mosque->phone,
                    'imam' => $mosque->imam_name,
                    'latitude' => $mosque->latitude,
                    'longitude' => $mosque->longitude,
                    'amenities' => [
                        'women' => $mosque->has_women_area,
                        'ablution' => $mosque->has_ablution,
                        'parking' => $mosque->has_parking,
                    ],
                    'prayer_times' => $mosque->prayerTimes,
                    'next_prayer' => $next,
                    'updated_at' => $mosque->prayerTimes?->updated_at?->diffForHumans() ?? 'Recently',
                ];
            });

        return response()->json($mosques);
    }

    /**
     * Compute next upcoming prayer time based on current time.
     */
    private function calculateNextPrayer($prayerTimes, Carbon $now): array
    {
        if (!$prayerTimes) {
            return [
                'name' => "Bomdod",
                'time' => '06:00',
                'target_timestamp' => $now->copy()->addHours(2)->timestamp,
                'is_tomorrow' => false,
            ];
        }

        $schedule = [
            'Bomdod (Azon)' => $prayerTimes->fajr_adhan,
            'Bomdod (Jamoat)' => $prayerTimes->fajr_iqama,
            'Quyosh' => $prayerTimes->sunrise,
            'Peshin (Jamoat)' => $prayerTimes->dhuhr_iqama,
            'Asr (Jamoat)' => $prayerTimes->asr_iqama,
            'Shom (Jamoat)' => $prayerTimes->maghrib_iqama,
            'Xufton (Jamoat)' => $prayerTimes->isha_iqama,
        ];

        $currentMinutes = $now->hour * 60 + $now->minute;

        foreach ($schedule as $name => $timeString) {
            if (!$timeString) continue;
            [$hour, $minute] = explode(':', $timeString);
            $prayerMinutes = (int)$hour * 60 + (int)$minute;

            if ($prayerMinutes > $currentMinutes) {
                $target = $now->copy()->setTime((int)$hour, (int)$minute, 0);
                return [
                    'name' => $name,
                    'time' => $timeString,
                    'target_timestamp' => $target->timestamp,
                    'is_tomorrow' => false,
                ];
            }
        }

        // If all scheduled prayers have passed today, target tomorrow's Fajr
        [$hour, $minute] = explode(':', $prayerTimes->fajr_iqama);
        $target = $now->copy()->addDay()->setTime((int)$hour, (int)$minute, 0);

        return [
            'name' => 'Bomdod (Jamoat)',
            'time' => $prayerTimes->fajr_iqama,
            'target_timestamp' => $target->timestamp,
            'is_tomorrow' => true,
        ];
    }
}
