<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'fajr_adhan',
        'fajr_iqama',
        'sunrise',
        'dhuhr_adhan',
        'dhuhr_iqama',
        'asr_adhan',
        'asr_iqama',
        'maghrib_adhan',
        'maghrib_iqama',
        'isha_adhan',
        'isha_iqama',
        'juma_bayan',
        'juma_iqama',
        'announcement',
        'updated_by',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Compute current prayer period and next upcoming prayer countdown details.
     */
    public function getStatus(?Carbon $now = null): array
    {
        $now = $now ? $now->copy()->setTimezone('Asia/Bishkek') : Carbon::now('Asia/Bishkek');
        $currMin = $now->hour * 60 + $now->minute;

        $parseMinutes = function (?string $timeStr): ?int {
            if (!$timeStr || !str_contains($timeStr, ':')) return null;
            [$h, $m] = explode(':', $timeStr);
            return (int)$h * 60 + (int)$m;
        };

        $fajrAdhan = $parseMinutes($this->fajr_adhan) ?? 355;
        $fajrIqama = $parseMinutes($this->fajr_iqama) ?? 385;
        $sunrise = $parseMinutes($this->sunrise) ?? 440;
        $dhuhrAdhan = $parseMinutes($this->dhuhr_adhan) ?? 765;
        $dhuhrIqama = $parseMinutes($this->dhuhr_iqama) ?? 780;
        $asrAdhan = $parseMinutes($this->asr_adhan) ?? 915;
        $asrIqama = $parseMinutes($this->asr_iqama) ?? 930;
        $maghribAdhan = $parseMinutes($this->maghrib_adhan) ?? 1028;
        $maghribIqama = $parseMinutes($this->maghrib_iqama) ?? 1035;
        $ishaAdhan = $parseMinutes($this->isha_adhan) ?? 1120;
        $ishaIqama = $parseMinutes($this->isha_iqama) ?? 1140;

        $isFriday = $now->isFriday();
        $targetJuma = $isFriday && $this->juma_iqama ? ($parseMinutes($this->juma_iqama) ?? $dhuhrIqama) : $dhuhrIqama;
        $dhuhrLabel = $isFriday ? 'Juma namozi' : 'Peshin jamoati';
        $dhuhrTime = $isFriday && $this->juma_iqama ? $this->juma_iqama : $this->dhuhr_iqama;

        if ($currMin < $fajrAdhan) {
            $currentName = 'Xufton namozi vaqti';
            $currentKey = 'isha';
            $nextName = 'Bomdod jamoati';
            $nextKey = 'fajr';
            $nextTime = $this->fajr_iqama;
            $target = $now->copy()->setTime((int)floor($fajrIqama / 60), $fajrIqama % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $fajrIqama) {
            $currentName = "Bomdod azoni o'qildi";
            $currentKey = 'fajr';
            $nextName = 'Bomdod jamoati';
            $nextKey = 'fajr';
            $nextTime = $this->fajr_iqama;
            $target = $now->copy()->setTime((int)floor($fajrIqama / 60), $fajrIqama % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $sunrise) {
            $currentName = 'Bomdod namozi vaqti';
            $currentKey = 'fajr';
            $nextName = 'Quyosh chiqishi';
            $nextKey = 'sunrise';
            $nextTime = $this->sunrise;
            $target = $now->copy()->setTime((int)floor($sunrise / 60), $sunrise % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $dhuhrAdhan) {
            $currentName = 'Choshgoh vaqti';
            $currentKey = 'sunrise';
            $nextName = $dhuhrLabel;
            $nextKey = 'dhuhr';
            $nextTime = $dhuhrTime;
            $target = $now->copy()->setTime((int)floor($targetJuma / 60), $targetJuma % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $dhuhrIqama) {
            $currentName = $isFriday ? 'Juma arafasi' : "Peshin azoni o'qildi";
            $currentKey = 'dhuhr';
            $nextName = $dhuhrLabel;
            $nextKey = 'dhuhr';
            $nextTime = $dhuhrTime;
            $target = $now->copy()->setTime((int)floor($targetJuma / 60), $targetJuma % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $asrAdhan) {
            $currentName = $isFriday ? 'Juma / Peshin vaqti' : 'Peshin namozi vaqti';
            $currentKey = 'dhuhr';
            $nextName = 'Asr jamoati';
            $nextKey = 'asr';
            $nextTime = $this->asr_iqama;
            $target = $now->copy()->setTime((int)floor($asrIqama / 60), $asrIqama % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $asrIqama) {
            $currentName = "Asr azoni o'qildi";
            $currentKey = 'asr';
            $nextName = 'Asr jamoati';
            $nextKey = 'asr';
            $nextTime = $this->asr_iqama;
            $target = $now->copy()->setTime((int)floor($asrIqama / 60), $asrIqama % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $maghribAdhan) {
            $currentName = 'Asr namozi vaqti';
            $currentKey = 'asr';
            $nextName = 'Shom jamoati';
            $nextKey = 'maghrib';
            $nextTime = $this->maghrib_iqama;
            $target = $now->copy()->setTime((int)floor($maghribIqama / 60), $maghribIqama % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $maghribIqama) {
            $currentName = "Shom azoni o'qildi";
            $currentKey = 'maghrib';
            $nextName = 'Shom jamoati';
            $nextKey = 'maghrib';
            $nextTime = $this->maghrib_iqama;
            $target = $now->copy()->setTime((int)floor($maghribIqama / 60), $maghribIqama % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $ishaAdhan) {
            $currentName = 'Shom namozi vaqti';
            $currentKey = 'maghrib';
            $nextName = 'Xufton jamoati';
            $nextKey = 'isha';
            $nextTime = $this->isha_iqama;
            $target = $now->copy()->setTime((int)floor($ishaIqama / 60), $ishaIqama % 60, 0);
            $isTomorrow = false;
        } elseif ($currMin < $ishaIqama) {
            $currentName = "Xufton azoni o'qildi";
            $currentKey = 'isha';
            $nextName = 'Xufton jamoati';
            $nextKey = 'isha';
            $nextTime = $this->isha_iqama;
            $target = $now->copy()->setTime((int)floor($ishaIqama / 60), $ishaIqama % 60, 0);
            $isTomorrow = false;
        } else {
            $currentName = 'Xufton namozi vaqti';
            $currentKey = 'isha';
            $nextName = 'Bomdod jamoati';
            $nextKey = 'fajr';
            $nextTime = $this->fajr_iqama;
            $target = $now->copy()->addDay()->setTime((int)floor($fajrIqama / 60), $fajrIqama % 60, 0);
            $isTomorrow = true;
        }

        $diffSeconds = max(0, $target->timestamp - $now->timestamp);
        $diffHours = (int)floor($diffSeconds / 3600);
        $diffMinutes = (int)floor(($diffSeconds % 3600) / 60);
        $diffSecs = $diffSeconds % 60;

        if ($diffHours > 0) {
            $diffText = "{$diffHours} soat-u {$diffMinutes} daqiqa qoldi";
            $diffShort = "{$diffHours}s {$diffMinutes}d";
        } elseif ($diffMinutes > 0) {
            $diffText = "{$diffMinutes} daqiqa qoldi";
            $diffShort = "{$diffMinutes} daqiqa";
        } else {
            $diffText = "{$diffSecs} soniya qoldi";
            $diffShort = "{$diffSecs} soniya";
        }

        return [
            'current_name' => $currentName,
            'current_key' => $currentKey,
            'next_name' => $nextName,
            'next_key' => $nextKey,
            'next_time' => $nextTime,
            'target_timestamp' => $target->timestamp,
            'diff_hours' => $diffHours,
            'diff_minutes' => $diffMinutes,
            'diff_seconds' => $diffSecs,
            'diff_text' => $diffText,
            'diff_short' => $diffShort,
            'is_tomorrow' => $isTomorrow,
        ];
    }
}

