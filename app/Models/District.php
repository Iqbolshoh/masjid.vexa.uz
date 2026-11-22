<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_uz',
        'name_ky',
        'slug',
        'sort_order',
    ];

    public function mosques()
    {
        return $this->hasMany(Mosque::class);
    }
}
