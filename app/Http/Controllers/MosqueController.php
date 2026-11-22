<?php

namespace App\Http\Controllers;

use App\Models\Mosque;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MosqueController extends Controller
{
    public function show($slug)
    {
        $mosque = Mosque::with(['district', 'prayerTimes', 'admin'])
            ->where('slug', $slug)
            ->firstOrFail();

        $now = Carbon::now('Asia/Bishkek');
        $currentTime = $now->format('H:i');
        $prayerStatus = $mosque->prayerTimes?->getStatus($now);

        $monthsUz = [
            1 => 'yanvar', 2 => 'fevral', 3 => 'mart', 4 => 'aprel',
            5 => 'may', 6 => 'iyun', 7 => 'iyul', 8 => 'avgust',
            9 => 'sentabr', 10 => 'oktabr', 11 => 'noyabr', 12 => 'dekabr'
        ];
        $daysUz = [
            0 => 'Yakshanba', 1 => 'Dushanba', 2 => 'Seshanba',
            3 => 'Chorshanba', 4 => 'Payshanba', 5 => 'Juma', 6 => 'Shanba'
        ];
        $formattedDate = $now->day . '-' . $monthsUz[$now->month] . ', ' . $now->year . '-yil (' . $daysUz[$now->dayOfWeek] . ')';

        return view('mosque-detail', compact('mosque', 'now', 'currentTime', 'prayerStatus', 'formattedDate'));
    }
}
