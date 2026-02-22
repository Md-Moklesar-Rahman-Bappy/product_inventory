<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Securities\Price;

class CategoryProductExport implements FromCollection, WithHeadings, WithTitle
{
    protected $category;

    public function __construct($categoryId)
    {
        $this->category = Category::findOrFail($categoryId);
    }

    public function collection(): Collection
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
                    optional($product->warranty_start)->format('Y-m-d'),
                    optional($product->warranty_end)->format('Y-m-d'),
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
