<?php

namespace App\Repositories;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Models\BoardingHouse;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Repository for interacting with boarding house data.
 */
class BoardingHouseRepository implements BoardingHouseRepositoryInterface
{
    /**
     * Get all boarding houses with optional search, city, and category filters.
     *
     * @param string|null $search
     * @param string|null $city
     * @param string|null $category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBoardingHouses(?string $search = null, ?string $city = null, ?string $category = null)
    {
        $query = BoardingHouse::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($city) {
            $query->whereHas('city', function (Builder $query) use ($city) {
                $query->where('slug', $city);
            });
        }

        if ($category) {
            $query->whereHas('category', function (Builder $query) use ($category) {
                $query->where('slug', $category);
            });
        }

        return $query->get();
    }

    /**
     * Get the most popular boarding houses based on transaction count.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPopularBoardingHouses($limit = 5)
    {
        return BoardingHouse::withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Get boarding houses by city slug.
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBoardingHouseByCitySlug($slug)
    {
        return BoardingHouse::whereHas('city', function (Builder $query) use ($slug) {
            $query->where('slug', $slug);
        })->get();
    }

    /**
     * Get boarding houses by category slug.
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBoardingHouseByCategorySlug($slug)
    {
        return BoardingHouse::whereHas('category', function (Builder $query) use ($slug) {
            $query->where('slug', $slug);
        })->get();
    }

    /**
     * Get a boarding house by its slug.
     *
     * @param string $slug
     * @return \App\Models\BoardingHouse|null
     */
    public function getBoardingHouseBySlug($slug)
    {
        return BoardingHouse::where('slug', $slug)->first();
    }
}
