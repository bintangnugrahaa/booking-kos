<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'name',
        'slug',
    ];

    /**
     * Get the boarding houses associated with the city.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class);
    }
}
