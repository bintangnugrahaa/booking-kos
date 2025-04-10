<?php

namespace App\Repositories;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Models\BoardingHouse;
use App\Models\Room;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BoardingHouseRepository implements BoardingHouseRepositoryInterface
{
    public function getAllBoardingHouses(?string $search = null, ?string $city = null, ?string $category = null)
    {
        return BoardingHouse::query()
            ->when($search, fn($query) => $query->where('name', 'like', "%{$search}%"))
            ->when($city, fn($query) =>
            $query->whereHas('city', fn(Builder $q) => $q->where('slug', $city)))
            ->when($category, fn($query) =>
            $query->whereHas('category', fn(Builder $q) => $q->where('slug', $category)))
            ->get();
    }

    public function getPopularBoardingHouses($limit = 5)
    {
        return BoardingHouse::withCount('transactions')
            ->orderByDesc('transactions_count')
            ->take($limit)
            ->get();
    }

    public function getBoardingHouseByCitySlug($slug)
    {
        return BoardingHouse::whereHas('city', fn(Builder $q) => $q->where('slug', $slug))->get();
    }

    public function getBoardingHouseByCategorySlug($slug)
    {
        return BoardingHouse::whereHas('category', fn(Builder $q) => $q->where('slug', $slug))->get();
    }

    public function getBoardingHouseBySlug($slug)
    {
        return BoardingHouse::where('slug', $slug)->first();
    }

    public function getBoardingHouseRoomById($id)
    {
        return Room::find($id);
    }
}
