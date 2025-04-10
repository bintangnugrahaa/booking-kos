<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private BoardingHouseRepositoryInterface $boardingHouseRepo;
    private CityRepositoryInterface $cityRepo;

    public function __construct(
        BoardingHouseRepositoryInterface $boardingHouseRepo,
        CityRepositoryInterface $cityRepo
    ) {
        $this->boardingHouseRepo = $boardingHouseRepo;
        $this->cityRepo = $cityRepo;
    }

    public function show(string $slug)
    {
        $city = $this->cityRepo->getCityBySlug($slug);
        $boardingHouses = $this->boardingHouseRepo->getBoardingHouseByCitySlug($slug);

        return view('pages.city.show', compact('boardingHouses', 'city'));
    }
}
