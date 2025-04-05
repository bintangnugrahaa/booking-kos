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
     * Show the page for finding boarding houses.
     *
     * @return \Illuminate\View\View
     */
    public function find()
    {
        $categories = $this->categoryRepository->getAllCategories();
        $cities = $this->cityRepository->getAllCities();

        return view('pages.boarding-house.find', compact('categories', 'cities'));
    }

    /**
     * Show details of a specific boarding house.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        return view('pages.boarding-house.show', compact('boardingHouse'));
    }

    /**
     * Show room details of a specific boarding house.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function rooms($slug)
    {
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        return view('pages.boarding-house.rooms', compact('boardingHouse'));
    }

    /**
     * Show filtered list of boarding houses based on search, city, and category.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function findResults(Request $request)
    {
        $boardingHouses = $this->boardingHouseRepository->getAllBoardingHouses(
            $request->search,
            $request->city,
            $request->category
        );

        return view('pages.boarding-house.index', compact('boardingHouses'));
    }
}
