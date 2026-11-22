<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Mosque;
use App\Models\PrayerLog;
use App\Models\PrayerTime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MosqueAdminController extends Controller
{
    /**
     * Display the mosque administration dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard');
        }

        $mosque = Mosque::with(['district', 'prayerTimes', 'logs.user'])
            ->where('admin_id', $user->id)
            ->first();

        if (!$mosque) {
            return view('admin.no-mosque');
        }

        return view('admin.dashboard', compact('mosque', 'user'));
    }

    /**
     * Update prayer times for a given mosque.
     */
    public function updatePrayerTimes(Request $request, Mosque $mosque)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $mosque->admin_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'fajr_adhan' => 'required|string|max:10',
            'fajr_iqama' => 'required|string|max:10',
            'sunrise' => 'required|string|max:10',
            'dhuhr_adhan' => 'required|string|max:10',
            'dhuhr_iqama' => 'required|string|max:10',
            'asr_adhan' => 'required|string|max:10',
            'asr_iqama' => 'required|string|max:10',
            'maghrib_adhan' => 'required|string|max:10',
            'maghrib_iqama' => 'required|string|max:10',
            'isha_adhan' => 'required|string|max:10',
            'isha_iqama' => 'required|string|max:10',
            'juma_bayan' => 'nullable|string|max:10',
            'juma_iqama' => 'nullable|string|max:10',
            'announcement' => 'nullable|string|max:1000',
        ]);

        $validated['updated_by'] = $user->id;

        $oldTimes = $mosque->prayerTimes ? $mosque->prayerTimes->toArray() : [];

        $prayerTimes = PrayerTime::updateOrCreate(
            ['mosque_id' => $mosque->id],
            $validated
        );

        // Record audit log
        PrayerLog::create([
            'mosque_id' => $mosque->id,
            'user_id' => $user->id,
            'changes_payload' => [
                'old' => $oldTimes,
                'new' => $validated,
            ],
            'comment' => "Prayer times updated.",
        ]);

        return back()->with('success', "Namoz vaqtlari muvaffaqiyatli saqlandi va saytda yangilandi!");
    }

    /**
     * Update mosque details, contact, amenities, and geographic coordinates.
     */
    public function updateDetails(Request $request, Mosque $mosque)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $mosque->admin_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'phone' => 'nullable|string|max:50',
            'imam_name' => 'nullable|string|max:150',
            'address' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'has_women_area' => 'nullable|boolean',
            'has_ablution' => 'nullable|boolean',
            'has_parking' => 'nullable|boolean',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['has_women_area'] = $request->has('has_women_area');
        $validated['has_ablution'] = $request->has('has_ablution');
        $validated['has_parking'] = $request->has('has_parking');

        $mosque->update($validated);

        return back()->with('success', "Masjid ma'lumotlari muvaffaqiyatli saqlandi!");
    }

    /**
     * Display the superadmin dashboard.
     */
    public function superadminDashboard()
    {
        $districts = District::withCount('mosques')->orderBy('sort_order')->get();
        $mosques = Mosque::with(['district', 'admin', 'prayerTimes'])->orderBy('id')->get();
        $admins = User::where('role', 'mosque_admin')->get();

        return view('admin.superadmin', compact('districts', 'mosques', 'admins'));
    }

    /**
     * Store a newly created mosque along with its assigned administrator.
     */
    public function storeMosque(Request $request)
    {
        $validated = $request->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'imam_name' => 'nullable|string|max:150',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'admin_name' => 'required|string|max:150',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:6',
        ]);

        // 1. Create Mosque Administrator User
        $admin = User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
            'role' => 'mosque_admin',
            'phone' => $validated['phone'],
            'is_active' => true,
        ]);

        // 2. Create Mosque record
        $slug = Str::slug($validated['name']);
        if (Mosque::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(10, 99);
        }

        $mosque = Mosque::create([
            'district_id' => $validated['district_id'],
            'admin_id' => $admin->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'address' => $validated['address'],
            'landmark' => $validated['landmark'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'imam_name' => $validated['imam_name'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'is_verified' => true,
        ]);

        // 3. Create Default Prayer Times
        PrayerTime::create([
            'mosque_id' => $mosque->id,
            'fajr_adhan' => '05:55',
            'fajr_iqama' => '06:25',
            'sunrise' => '07:22',
            'dhuhr_adhan' => '12:45',
            'dhuhr_iqama' => '13:00',
            'asr_adhan' => '15:15',
            'asr_iqama' => '15:30',
            'maghrib_adhan' => '17:08',
            'maghrib_iqama' => '17:15',
            'isha_adhan' => '18:40',
            'isha_iqama' => '19:00',
            'juma_bayan' => '12:30',
            'juma_iqama' => '13:00',
            'updated_by' => $admin->id,
        ]);

        return back()->with('success', "Yangi masjid '{$mosque->name}' va uning admini ('{$admin->email}') muvaffaqiyatli yaratildi!");
    }
}
