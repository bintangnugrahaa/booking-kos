<?php

namespace App\Interfaces;

/**
 * Interface for category repository to interact with category data.
 */
interface CategoryRepositoryInterface
{
    /**
     * Get all categories.
     *
     * @return mixed
     */
    public function getAllCategories();

    /**
     * Get a category by its slug.
     *
     * @param string $slug
     * @return mixed
     */
    public function getCategoryBySlug($slug);
}
