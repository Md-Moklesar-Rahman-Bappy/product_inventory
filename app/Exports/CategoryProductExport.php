<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Services\ProductRowMapper;
use Maatwebsite\Excel\Concerns\WithTitle;

class CategoryProductExport implements FromQuery, WithHeadings, WithMapping, WithTitle
{
    protected $category;

    public function __construct($categoryId)
    {
        $this->category = Category::findOrFail($categoryId);
    }

    public function query(): Builder
    {
        return Product::with(['category', 'brand', 'model'])
            ->where('category_id', $this->category->id)
            ->orderBy('id', 'desc');
    }

    public function map($product): array
    {
        return ProductRowMapper::mapRow($product);
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
