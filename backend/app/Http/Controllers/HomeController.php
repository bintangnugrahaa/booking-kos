<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private CityRepositoryInterface $cityRepo;
    private CategoryRepositoryInterface $categoryRepo;
    private BoardingHouseRepositoryInterface $boardingHouseRepo;

    public function __construct(
        CityRepositoryInterface $cityRepo,
        CategoryRepositoryInterface $categoryRepo,
        BoardingHouseRepositoryInterface $boardingHouseRepo
    ) {
        $this->cityRepo = $cityRepo;
        $this->categoryRepo = $categoryRepo;
        $this->boardingHouseRepo = $boardingHouseRepo;
    }

    public function index()
    {
        $categories = $this->categoryRepo->getAllCategories();
        $popularBoardingHouses = $this->boardingHouseRepo->getPopularBoardingHouses();
        $cities = $this->cityRepo->getAllCities();
        $boardingHouses = $this->boardingHouseRepo->getAllBoardingHouses();

        return view('pages.home', compact(
            'categories',
            'popularBoardingHouses',
            'cities',
            'boardingHouses'
        ));
    }
}
