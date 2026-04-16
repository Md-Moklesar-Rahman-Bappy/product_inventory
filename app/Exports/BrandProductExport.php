<?php

namespace App\Exports;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
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
        return Product::with(['model', 'category'])
            ->where('brand_id', $this->brand->id)
            ->orderBy('id', 'desc');
    }

    public function map($product): array
    {
        return [
            $product->product_name,
            '৳ '.number_format($product->price, 2),
            $this->brand->brand_name,
            $product->model?->model_name,
            $product->category?->category_name,
            $product->serial_no,
            $product->project_serial_no,
            $product->position,
            $product->user_description,
            $product->remarks,
            optional($product->warranty_start)->format('d/m/Y'),
            optional($product->warranty_end)->format('d/m/Y'),
        ];
    }

    public function headings(): array
    {
        return [
            'Product Name', 'Price', 'Brand', 'Model', 'Category',
            'Serial No', 'Project Serial No', 'Position',
            'User Description', 'Remarks', 'Warranty Start', 'Warranty End',
        ];
    }

    public function title(): string
    {
        return $this->brand->brand_name;
    }
}
