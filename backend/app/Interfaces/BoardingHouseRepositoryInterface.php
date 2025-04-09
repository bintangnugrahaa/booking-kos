<?php

namespace App\Interfaces;

interface BoardingHouseRepositoryInterface
{
    public function getAllBoardingHouses(
        ?string $search = null,
        ?string $city = null,
        ?string $category = null
    );

    public function getPopularBoardingHouses(int $limit = 5);

    public function getBoardingHouseByCitySlug(string $slug);

    public function getBoardingHouseByCategorySlug(string $slug);

    public function getBoardingHouseBySlug(string $slug);

    public function getBoardingHouseRoomById(int $id);
}
