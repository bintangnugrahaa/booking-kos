<?php

namespace App\Interfaces;

/**
 * Interface for boarding house repository to interact with data storage.
 */
interface BoardingHouseRepositoryInterface
{
    /**
     * Get all boarding houses with optional search, city, and category filters.
     *
     * @param string|null $search
     * @param string|null $city
     * @param string|null $category
     * @return mixed
     */
    public function getAllBoardingHouses(?string $search = null, ?string $city = null, ?string $category = null);

    /**
     * Get the most popular boarding houses with an optional limit.
     *
     * @param int $limit
     * @return mixed
     */
    public function getPopularBoardingHouses(int $limit = 5);

    /**
     * Get a boarding house by its city slug.
     *
     * @param string $slug
     * @return mixed
     */
    public function getBoardingHouseByCitySlug(string $slug);

    /**
     * Get a boarding house by its category slug.
     *
     * @param string $slug
     * @return mixed
     */
    public function getBoardingHouseByCategorySlug(string $slug);

    /**
     * Get a boarding house by its unique slug.
     *
     * @param string $slug
     * @return mixed
     */
    public function getBoardingHouseBySlug(string $slug);
}
