<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Controller for handling boarding house related actions.
 */
class BoardingHouseController extends Controller
{
    private CityRepositoryInterface $cityRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private BoardingHouseRepositoryInterface $boardingHouseRepository;

    /**
     * BoardingHouseController constructor.
     *
     * @param CityRepositoryInterface $cityRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param BoardingHouseRepositoryInterface $boardingHouseRepository
     */
    public function __construct(
        CityRepositoryInterface $cityRepository,
        CategoryRepositoryInterface $categoryRepository,
        BoardingHouseRepositoryInterface $boardingHouseRepository
    ) {
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->boardingHouseRepository = $boardingHouseRepository;
    }

    /**
     * Show the boarding house find page with available categories and cities.
     *
     * @return \Illuminate\View\View
     */
    public function find()
    {
        $categories = $this->categoryRepository->getAllCategories();
        $cities = $this->cityRepository->getAllCities();

        return view('pages.boarding-house.find', compact('categories', 'cities'));
    }
}
