<?php

namespace App\Models;

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
}
