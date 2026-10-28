<?php

namespace App\Exports;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Services\ProductRowMapper;
use Maatwebsite\Excel\Concerns\WithTitle;

class BrandProductExport implements FromQuery, WithHeadings, WithMapping, WithTitle
{
    protected $brand;

    public function __construct($brandId)
    {
        $this->brand = Brand::findOrFail($brandId);
    }

    public function query(): Builder
    {
        return Product::with(['category', 'brand', 'model'])
            ->where('brand_id', $this->brand->id)
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
        return $this->brand->brand_name;
    }
}
