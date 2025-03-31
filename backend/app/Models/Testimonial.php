<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'boarding_house_id',
        'photo',
        'name',
        'content',
        'rating',
    ];

    /**
     * Get the boarding house associated with the testimonial.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}
