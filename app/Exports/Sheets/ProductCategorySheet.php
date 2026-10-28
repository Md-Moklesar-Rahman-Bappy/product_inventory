<?php

namespace App\Exports\Sheets;

use App\Models\Product;
use App\Services\ProductRowMapper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductCategorySheet implements FromCollection, WithTitle, WithHeadings
{
    protected $category;

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function collection()
    {
        return Product::with(['category', 'brand', 'model'])
            ->where('category_id', $this->category->id)
            ->get()
            ->map(function ($product) {
                return ProductRowMapper::mapRow($product);
            });
    }

    public function headings(): array
    {
        return ProductRowMapper::headings();
    }

    public function title(): string
    {
        return $this->category->category_name;
    }
}
