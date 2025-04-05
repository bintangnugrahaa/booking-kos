<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Controller for handling city-related actions.
 */
class CityController extends Controller
{
    private BoardingHouseRepositoryInterface $boardingHouseRepository;
    private CityRepositoryInterface $cityRepository;

    /**
     * CityController constructor.
     *
     * @param BoardingHouseRepositoryInterface $boardingHouseRepository
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(
        BoardingHouseRepositoryInterface $boardingHouseRepository,
        CityRepositoryInterface $cityRepository
    ) {
        $this->boardingHouseRepository = $boardingHouseRepository;
        $this->cityRepository = $cityRepository;
    }

    /**
     * Show boarding houses by city slug.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $city = $this->cityRepository->getCityBySlug($slug);
        $boardingHouses = $this->boardingHouseRepository->getBoardingHouseByCitySlug($slug);

        return view('pages.city.show', compact('boardingHouses', 'city'));
    }
}
