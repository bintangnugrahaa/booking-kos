<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private BoardingHouseRepositoryInterface $boardingHouseRepo;
    private CategoryRepositoryInterface $categoryRepo;

    public function __construct(
        BoardingHouseRepositoryInterface $boardingHouseRepo,
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->boardingHouseRepo = $boardingHouseRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function show(string $slug)
    {
        $category = $this->categoryRepo->getCategoryBySlug($slug);
        $boardingHouses = $this->boardingHouseRepo->getBoardingHouseByCategorySlug($slug);

        return view('pages.category.show', compact('boardingHouses', 'category'));
    }
}
