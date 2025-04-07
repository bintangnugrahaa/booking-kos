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
     * Get popular boarding houses.
     *
     * @param int $limit Number of items to retrieve
     * @return mixed
     */
    public function getPopularBoardingHouses(int $limit = 5);

    /**
     * Get boarding houses by city slug.
     *
     * @param string $slug
     * @return mixed
     */
    public function getBoardingHouseByCitySlug(string $slug);

    /**
     * Get boarding houses by category slug.
     *
     * @param string $slug
     * @return mixed
     */
    public function getBoardingHouseByCategorySlug(string $slug);

    /**
     * Get a boarding house by its slug.
     *
     * @param string $slug
     * @return mixed
     */
    public function getBoardingHouseBySlug(string $slug);

    /**
     * Get room details by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function getBoardingHouseRoomById($id);
}
