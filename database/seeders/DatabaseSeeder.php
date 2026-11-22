<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Mosque;
use App\Models\PrayerTime;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Superadmin
        $superadmin = User::firstOrCreate(
            ['email' => 'admin@vexa.uz'],
            [
                'name' => 'Bosh Administrator',
                'password' => Hash::make('admin12345'),
                'role' => 'superadmin',
                'phone' => '+996 555 123 456',
                'is_active' => true,
            ]
        );

        // 2. Districts of Osh region
        $districtsData = [
            ['name_uz' => "O'sh shahri", 'name_ky' => "Ош шаары", 'slug' => 'osh-shahri', 'sort_order' => 1],
            ['name_uz' => "Qorasuv tumani", 'name_ky' => "Кара-Суу району", 'slug' => 'qorasuv', 'sort_order' => 2],
            ['name_uz' => "Novqat tumani", 'name_ky' => "Ноокат району", 'slug' => 'novqat', 'sort_order' => 3],
            ['name_uz' => "O'zgan tumani", 'name_ky' => "Өзгөн району", 'slug' => 'ozgan', 'sort_order' => 4],
            ['name_uz' => "Aravon tumani", 'name_ky' => "Араван району", 'slug' => 'aravon', 'sort_order' => 5],
            ['name_uz' => "Oloy tumani", 'name_ky' => "Алай району", 'slug' => 'oloy', 'sort_order' => 6],
            ['name_uz' => "Qoraqulja tumani", 'name_ky' => "Кара-Кулжа району", 'slug' => 'qoraqulja', 'sort_order' => 7],
            ['name_uz' => "Chon-Oloy tumani", 'name_ky' => "Чоң-Алай району", 'slug' => 'chon-oloy', 'sort_order' => 8],
        ];

        $districtMap = [];
        foreach ($districtsData as $d) {
            $created = District::updateOrCreate(['slug' => $d['slug']], $d);
            $districtMap[$d['slug']] = $created->id;
        }

        // 3. Sample Mosques with Admins and Prayer Times
        $mosquesData = [
            [
                'name' => "Sulaymon-Too Markaziy Jome Masjidi",
                'district_slug' => 'osh-shahri',
                'address' => "O'sh sh., Qurbonjon Dodxo ko'chasi 14",
                'landmark' => "Sulaymon tog'i etagi",
                'phone' => "+996 3222 5-41-20",
                'imam_name' => "Ubaydulloh domla",
                'latitude' => 40.528312,
                'longitude' => 72.793645,
                'capacity' => 5000,
                'has_women_area' => true,
                'has_ablution' => true,
                'has_parking' => true,
                'description' => "O'sh viloyati va shahrining bosh markaziy jome masjidi.",
                'admin_name' => "Sulaymon-Too Masjid Mas'uli",
                'admin_email' => "sulaymon@vexa.uz",
                'prayer' => [
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
                    'announcement' => "Juma namozi ma'ruzasi soat 12:30 da boshlanadi. Avtoturargoh shimoliy darvoza tomonda.",
                ],
            ],
            [
                'name' => "Imom al-Buxoriy Jome Masjidi",
                'district_slug' => 'osh-shahri',
                'address' => "O'sh sh., Alisher Navoiy ko'chasi 88",
                'landmark' => "O'sh davlat universiteti bosh binosi yaqinida",
                'phone' => "+996 550 223 344",
                'imam_name' => "Muhammad solih qori",
                'latitude' => 40.518621,
                'longitude' => 72.802115,
                'capacity' => 2500,
                'has_women_area' => true,
                'has_ablution' => true,
                'has_parking' => true,
                'description' => "Shahar markazidagi gavjum va qulay jome masjid.",
                'admin_name' => "Buxoriy Masjid Mas'uli",
                'admin_email' => "buxoriy@vexa.uz",
                'prayer' => [
                    'fajr_adhan' => '05:55',
                    'fajr_iqama' => '06:30',
                    'sunrise' => '07:22',
                    'dhuhr_adhan' => '12:45',
                    'dhuhr_iqama' => '13:05',
                    'asr_adhan' => '15:15',
                    'asr_iqama' => '15:35',
                    'maghrib_adhan' => '17:08',
                    'maghrib_iqama' => '17:13',
                    'isha_adhan' => '18:40',
                    'isha_iqama' => '19:05',
                    'juma_bayan' => '12:20',
                    'juma_iqama' => '13:00',
                    'announcement' => "Tahoratxona to'liq ta'mirdan chiqdi, issiq suv ta'minoti mavjud.",
                ],
            ],
            [
                'name' => "As-Saraxsiy Jome Masjidi",
                'district_slug' => 'osh-shahri',
                'address' => "O'sh sh., Shark massivi, Bobur ko'chasi",
                'landmark' => "Shark bozori mo'ljali",
                'phone' => "+996 772 889 900",
                'imam_name' => "Abdurrahim hoji",
                'latitude' => 40.537240,
                'longitude' => 72.821410,
                'capacity' => 1800,
                'has_women_area' => false,
                'has_ablution' => true,
                'has_parking' => true,
                'description' => "Shark aholi yashash massividagi jome masjidi.",
                'admin_name' => "Saraxsiy Masjid Mas'uli",
                'admin_email' => "saraxsiy@vexa.uz",
                'prayer' => [
                    'fajr_adhan' => '05:55',
                    'fajr_iqama' => '06:20',
                    'sunrise' => '07:22',
                    'dhuhr_adhan' => '12:45',
                    'dhuhr_iqama' => '13:00',
                    'asr_adhan' => '15:15',
                    'asr_iqama' => '15:30',
                    'maghrib_adhan' => '17:08',
                    'maghrib_iqama' => '17:15',
                    'isha_adhan' => '18:40',
                    'isha_iqama' => '18:55',
                    'juma_bayan' => '12:30',
                    'juma_iqama' => '13:00',
                    'announcement' => "Xufton namozi jamoat vaqti 18:55 da o'qilmoqda.",
                ],
            ],
            [
                'name' => "Ravza Jome Masjidi",
                'district_slug' => 'osh-shahri',
                'address' => "O'sh sh., Cheryomushki mavzesi, Lenin ko'chasi 210",
                'landmark' => "Cheryomushki poliklinikasi yonida",
                'phone' => "+996 558 776 543",
                'imam_name' => "Nurmuhammad qori",
                'latitude' => 40.541280,
                'longitude' => 72.784530,
                'capacity' => 1200,
                'has_women_area' => false,
                'has_ablution' => true,
                'has_parking' => false,
                'description' => "Cheryomushki mikrorayonidagi shinam mahalla masjidi.",
                'admin_name' => "Ravza Masjid Mas'uli",
                'admin_email' => "ravza@vexa.uz",
                'prayer' => [
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
                    'announcement' => null,
                ],
            ],
            [
                'name' => "Shahobiddin Ota Jome Masjidi",
                'district_slug' => 'qorasuv',
                'address' => "Qorasuv shahri, Markaziy ko'cha 15",
                'landmark' => "Qorasuv xalqaro bozori yaqinida",
                'phone' => "+996 700 112 233",
                'imam_name' => "Ibrohim qori",
                'latitude' => 40.704250,
                'longitude' => 72.868510,
                'capacity' => 3000,
                'has_women_area' => true,
                'has_ablution' => true,
                'has_parking' => true,
                'description' => "Qorasuv tumanining asosiy yirik jome masjidi.",
                'admin_name' => "Qorasuv Masjid Mas'uli",
                'admin_email' => "qorasuv@vexa.uz",
                'prayer' => [
                    'fajr_adhan' => '05:55',
                    'fajr_iqama' => '06:25',
                    'sunrise' => '07:21',
                    'dhuhr_adhan' => '12:45',
                    'dhuhr_iqama' => '13:00',
                    'asr_adhan' => '15:15',
                    'asr_iqama' => '15:30',
                    'maghrib_adhan' => '17:07',
                    'maghrib_iqama' => '17:15',
                    'isha_adhan' => '18:40',
                    'isha_iqama' => '19:00',
                    'juma_bayan' => '12:30',
                    'juma_iqama' => '13:00',
                    'announcement' => "Bozor ahli uchun tahoratxona doimiy ochiq.",
                ],
            ],
            [
                'name' => "Hazrati Ali Jome Masjidi",
                'district_slug' => 'novqat',
                'address' => "Novqat sh., To'xtagul ko'chasi 45",
                'landmark' => "Novqat tuman hokimiyati ro'parasida",
                'phone' => "+996 779 334 455",
                'imam_name' => "Zokirjon domla",
                'latitude' => 40.266710,
                'longitude' => 72.616720,
                'capacity' => 2000,
                'has_women_area' => false,
                'has_ablution' => true,
                'has_parking' => true,
                'description' => "Novqat tuman markazidagi muhtasham jome masjid.",
                'admin_name' => "Novqat Masjid Mas'uli",
                'admin_email' => "novqat@vexa.uz",
                'prayer' => [
                    'fajr_adhan' => '05:56',
                    'fajr_iqama' => '06:30',
                    'sunrise' => '07:23',
                    'dhuhr_adhan' => '12:46',
                    'dhuhr_iqama' => '13:00',
                    'asr_adhan' => '15:16',
                    'asr_iqama' => '15:30',
                    'maghrib_adhan' => '17:09',
                    'maghrib_iqama' => '17:15',
                    'isha_adhan' => '18:41',
                    'isha_iqama' => '19:00',
                    'juma_bayan' => '12:30',
                    'juma_iqama' => '13:00',
                    'announcement' => null,
                ],
            ],
            [
                'name' => "O'zgan Markaziy Jome Masjidi",
                'district_slug' => 'ozgan',
                'address' => "O'zgan sh., Manas ko'chasi 12",
                'landmark' => "Tarixiy Minorai O'zgan me'moriy majmuasi yonida",
                'phone' => "+996 552 445 566",
                'imam_name' => "Akbarali qori",
                'latitude' => 40.768910,
                'longitude' => 73.300520,
                'capacity' => 3500,
                'has_women_area' => true,
                'has_ablution' => true,
                'has_parking' => true,
                'description' => "Tarixiy O'zgan shahrining eng qadimiy va ko'rkam jome masjidi.",
                'admin_name' => "O'zgan Masjid Mas'uli",
                'admin_email' => "ozgan@vexa.uz",
                'prayer' => [
                    'fajr_adhan' => '05:52',
                    'fajr_iqama' => '06:20',
                    'sunrise' => '07:18',
                    'dhuhr_adhan' => '12:42',
                    'dhuhr_iqama' => '13:00',
                    'asr_adhan' => '15:12',
                    'asr_iqama' => '15:30',
                    'maghrib_adhan' => '17:05',
                    'maghrib_iqama' => '17:12',
                    'isha_adhan' => '18:38',
                    'isha_iqama' => '18:55',
                    'juma_bayan' => '12:30',
                    'juma_iqama' => '13:00',
                    'announcement' => "Dushanba kunidan boshlab Xufton jamoati 18:55 ga o'tkazildi.",
                ],
            ],
            [
                'name' => "Aravon Markaziy Jome Masjidi",
                'district_slug' => 'aravon',
                'address' => "Aravon tumani, Do'stlik ko'chasi 20",
                'landmark' => "Aravon markaziy istirohat bog'i yonida",
                'phone' => "+996 708 556 677",
                'imam_name' => "Hasanboy domla",
                'latitude' => 40.513320,
                'longitude' => 72.496730,
                'capacity' => 1500,
                'has_women_area' => false,
                'has_ablution' => true,
                'has_parking' => true,
                'description' => "Aravon tumanidagi markaziy jome masjidi.",
                'admin_name' => "Aravon Masjid Mas'uli",
                'admin_email' => "aravon@vexa.uz",
                'prayer' => [
                    'fajr_adhan' => '05:56',
                    'fajr_iqama' => '06:25',
                    'sunrise' => '07:23',
                    'dhuhr_adhan' => '12:46',
                    'dhuhr_iqama' => '13:00',
                    'asr_adhan' => '15:16',
                    'asr_iqama' => '15:30',
                    'maghrib_adhan' => '17:09',
                    'maghrib_iqama' => '17:15',
                    'isha_adhan' => '18:41',
                    'isha_iqama' => '19:00',
                    'juma_bayan' => '12:30',
                    'juma_iqama' => '13:00',
                    'announcement' => null,
                ],
            ],
        ];

        foreach ($mosquesData as $mData) {
            // 1. Create or get admin user
            $admin = User::firstOrCreate(
                ['email' => $mData['admin_email']],
                [
                    'name' => $mData['admin_name'],
                    'password' => Hash::make('masjid123'),
                    'role' => 'mosque_admin',
                    'phone' => $mData['phone'],
                    'is_active' => true,
                ]
            );

            // 2. Create Mosque
            $slug = Str::slug($mData['name']);
            $mosque = Mosque::updateOrCreate(
                ['slug' => $slug],
                [
                    'district_id' => $districtMap[$mData['district_slug']],
                    'admin_id' => $admin->id,
                    'name' => $mData['name'],
                    'slug' => $slug,
                    'address' => $mData['address'],
                    'landmark' => $mData['landmark'],
                    'phone' => $mData['phone'],
                    'imam_name' => $mData['imam_name'],
                    'latitude' => $mData['latitude'],
                    'longitude' => $mData['longitude'],
                    'capacity' => $mData['capacity'],
                    'has_women_area' => $mData['has_women_area'],
                    'has_ablution' => $mData['has_ablution'],
                    'has_parking' => $mData['has_parking'],
                    'description' => $mData['description'],
                    'is_verified' => true,
                ]
            );

            // 3. Create or update Prayer times
            $prayerData = $mData['prayer'];
            $prayerData['mosque_id'] = $mosque->id;
            $prayerData['updated_by'] = $admin->id;
            PrayerTime::updateOrCreate(['mosque_id' => $mosque->id], $prayerData);
        }
    }
}
