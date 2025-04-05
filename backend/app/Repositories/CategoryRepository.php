<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

/**
 * Repository for interacting with category data.
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get all categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories()
    {
        return Category::all();
    }

    /**
     * Get a category by its slug.
     *
     * @param string $slug
     * @return \App\Models\Category|null
     */
    public function getCategoryBySlug($slug)
    {
        return Category::where('slug', $slug)->first();
    }
}
