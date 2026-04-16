<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AllCategoriesExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        Category::with('products.brand', 'products.model')
            ->has('products')
            ->orderBy('created_at', 'desc')
            ->chunk(100, function ($categories) use (&$sheets) {
                foreach ($categories as $category) {
                    $sheets[] = new CategorySheetExport($category);
                }
            });

        return $sheets;
    }
}
