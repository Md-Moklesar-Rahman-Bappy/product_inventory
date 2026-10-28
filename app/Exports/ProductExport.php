<?php

namespace App\Exports;

use App\Models\Product;
use App\Services\ProductRowMapper;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromQuery, WithHeadings, WithMapping
{
    public function query(): Builder
    {
        return Product::with(['category', 'brand', 'model'])
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
}
