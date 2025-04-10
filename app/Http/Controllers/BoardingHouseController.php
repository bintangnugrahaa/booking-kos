<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use Illuminate\Http\Request;

class BoardingHouseController extends Controller
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

    public function find()
    {
        $categories = $this->categoryRepo->getAllCategories();
        $cities = $this->cityRepo->getAllCities();

        return view('pages.boarding-house.find', compact('categories', 'cities'));
    }

    public function show(string $slug)
    {
        $boardingHouse = $this->boardingHouseRepo->getBoardingHouseBySlug($slug);
        return view('pages.boarding-house.show', compact('boardingHouse'));
    }

    public function rooms(string $slug)
    {
        $boardingHouse = $this->boardingHouseRepo->getBoardingHouseBySlug($slug);
        return view('pages.boarding-house.rooms', compact('boardingHouse'));
    }

    public function findResults(Request $request)
    {
        $boardingHouses = $this->boardingHouseRepo->getAllBoardingHouses(
            $request->search,
            $request->city,
            $request->category
        );

        return view('pages.boarding-house.index', compact('boardingHouses'));
    }
}
