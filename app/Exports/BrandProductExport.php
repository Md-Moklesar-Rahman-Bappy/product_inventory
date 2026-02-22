<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class BrandProductExport implements FromCollection, WithHeadings, WithTitle
{
    protected $brand;

    public function __construct($brandId)
    {
        $this->brand = Brand::findOrFail($brandId);
    }

    public function collection(): Collection
    {
        return Product::with(['model', 'category'])
            ->where('brand_id', $this->brand->id)
            ->get()
            ->map(function ($product) {
                return [
                    $product->product_name,
                    '৳ ' . number_format($product->price, 2),
                    $this->brand->brand_name,
                    $product->model?->model_name,
                    $product->category?->category_name,
                    $product->serial_no,
                    $product->project_serial_no,
                    $product->position,
                    $product->user_description,
                    $product->remarks,
                    optional($product->warranty_start)->format('Y-m-d'),
                    optional($product->warranty_end)->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Product Name', 'Price', 'Brand', 'Model', 'Category',
            'Serial No', 'Project Serial No', 'Position',
            'User Description', 'Remarks', 'Warranty Start', 'Warranty End'
        ];
    }

    public function title(): string
    {
        return $this->brand->brand_name;
    }
}
