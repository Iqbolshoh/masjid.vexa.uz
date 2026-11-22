<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Mosque;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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

        // Calculate next prayer globally for Osh (reference: first mosque or Sulaymon-Too)
        $refMosque = $mosques->firstWhere('slug', 'sulaymon-too-markaziy-jome-masjidi') ?? $mosques->first();
        $nextPrayerInfo = $this->calculateNextPrayer($refMosque?->prayerTimes, $now);

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

    public function getMosquesApi()
    {
        $now = Carbon::now('Asia/Bishkek');

        $mosques = Mosque::with(['district', 'prayerTimes'])
            ->where('is_verified', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($m) use ($now) {
                $next = $this->calculateNextPrayer($m->prayerTimes, $now);
                return [
                    'id' => $m->id,
                    'name' => $m->name,
                    'slug' => $m->slug,
                    'district' => $m->district->name_uz,
                    'address' => $m->address,
                    'phone' => $m->phone,
                    'imam' => $m->imam_name,
                    'latitude' => $m->latitude,
                    'longitude' => $m->longitude,
                    'amenities' => [
                        'women' => $m->has_women_area,
                        'ablution' => $m->has_ablution,
                        'parking' => $m->has_parking,
                    ],
                    'prayer_times' => $m->prayerTimes,
                    'next_prayer' => $next,
                    'updated_at' => $m->prayerTimes?->updated_at?->diffForHumans() ?? 'Yaqinda',
                ];
            });

        return response()->json($mosques);
    }

    private function calculateNextPrayer($prayerTimes, Carbon $now)
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

        foreach ($schedule as $name => $timeStr) {
            if (!$timeStr) continue;
            [$h, $m] = explode(':', $timeStr);
            $prayerMinutes = (int)$h * 60 + (int)$m;

            if ($prayerMinutes > $currentMinutes) {
                $target = $now->copy()->setTime((int)$h, (int)$m, 0);
                return [
                    'name' => $name,
                    'time' => $timeStr,
                    'target_timestamp' => $target->timestamp,
                    'is_tomorrow' => false,
                ];
            }
        }

        // If all prayers passed today, next is tomorrow's Fajr
        [$h, $m] = explode(':', $prayerTimes->fajr_iqama);
        $target = $now->copy()->addDay()->setTime((int)$h, (int)$m, 0);

        return [
            'name' => 'Bomdod (Jamoat)',
            'time' => $prayerTimes->fajr_iqama,
            'target_timestamp' => $target->timestamp,
            'is_tomorrow' => true,
        ];
    }
}
