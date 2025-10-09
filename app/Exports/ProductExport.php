<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with(['category', 'brand', 'model'])->get()->map(function ($product) {
            return [
                    $product->product_name,
                    '৳ ' . number_format($product->price, 2),
                    $product->category?->category_name,
                    $product->brand?->brand_name,
                    $product->model?->model_name,
                    $product->serial_no,
                    $product->project_serial_no,
                    $product->position,
                    $product->user_description,
                    $product->remarks,
                    $product->warranty_start,
                    $product->warranty_end,
                ];
        });
    }

    public function headings(): array
    {
        return [
                'Product Name',
                'Price',
                'Category',
                'Brand',
                'Model',
                'Serial No',
                'Project Serial No',
                'Position',
                'User Description',
                'Remarks',
                'Warranty Start',
                'Warranty End',
            ];
    }
}
