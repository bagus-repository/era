<?php
namespace App\Services;

use App\Models\Lookup;

class LookupService
{
    public static function getCategoryBy(string $category)
    {
        return Lookup::where('category', $category)->get();
    }
}