<?php

namespace App\Interfaces;

/**
 * Interface for city repository to interact with city data.
 */
interface CityRepositoryInterface
{
    /**
     * Get all cities.
     *
     * @return mixed
     */
    public function getAllCities();

    /**
     * Get a city by its slug.
     *
     * @param string $slug
     * @return mixed
     */
    public function getCityBySlug($slug);
}
