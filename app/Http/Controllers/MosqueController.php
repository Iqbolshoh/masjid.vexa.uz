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

        return view('mosque-detail', compact('mosque', 'now', 'currentTime', 'prayerStatus'));
    }
}
