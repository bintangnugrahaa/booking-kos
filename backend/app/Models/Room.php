<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'boarding_house_id',
        'name',
        'room_type',
        'square_feet',
        'price_per_month',
        'is_available',
    ];

    /**
     * Get the boarding house associated with the room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    /**
     * Get the images associated with the room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }
}
