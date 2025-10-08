<?php

namespace App\Exports\Sheets;

use App\Models\Product;
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
        return Product::with(['brand', 'model'])
            ->where('category_id', $this->category->id)
            ->get()
            ->map(function ($product) {
                return [
                    $product->product_name,
                    '৳ ' . number_format($product->price, 2),
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
            'Product Name', 'Price', 'Brand', 'Model',
            'Serial No', 'Project Serial No', 'Position',
            'User Description', 'Remarks', 'Warranty Start', 'Warranty End'
        ];
    }

    public function title(): string
    {
        return $this->category->category_name;
    }
}
