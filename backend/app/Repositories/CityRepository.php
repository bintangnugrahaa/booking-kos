<?php

namespace App\Repositories;

use App\Interfaces\CityRepositoryInterface;
use App\Models\City;

/**
 * Repository for interacting with city data.
 */
class CityRepository implements CityRepositoryInterface
{
    /**
     * Get all cities.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCities()
    {
        return City::all();
    }

    /**
     * Get a city by its slug.
     *
     * @param string $slug
     * @return \App\Models\City|null
     */
    public function getCityBySlug($slug)
    {
        return City::where('slug', $slug)->first();
    }
}
