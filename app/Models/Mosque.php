<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'admin_id',
        'name',
        'slug',
        'address',
        'landmark',
        'phone',
        'imam_name',
        'latitude',
        'longitude',
        'image',
        'capacity',
        'has_women_area',
        'has_ablution',
        'has_parking',
        'description',
        'is_verified',
    ];

    protected $casts = [
        'has_women_area' => 'boolean',
        'has_ablution' => 'boolean',
        'has_parking' => 'boolean',
        'is_verified' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function prayerTimes()
    {
        return $this->hasOne(PrayerTime::class);
    }

    public function logs()
    {
        return $this->hasMany(PrayerLog::class)->latest();
    }
}
