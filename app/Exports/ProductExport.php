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
                'product_name'      => $product->product_name,
                // Export plain numeric price for easier re-import
                'price'             => $product->price,
                'category'          => $product->category?->category_name,
                'brand'             => $product->brand?->brand_name,
                'model'             => $product->model?->model_name,
                'serial_no'         => $product->serial_no,
                'project_serial_no' => $product->project_serial_no,
                'position'          => $product->position,
                // Clean up newlines so CSV/XLSX stays tidy
                'user_description'  => str_replace(["\r", "\n"], ' ', $product->user_description),
                'remarks'           => str_replace(["\r", "\n"], ' ', $product->remarks),
                // Format warranty dates for readability
                'warranty_start'    => optional($product->warranty_start)->format('m/d/Y'),
                'warranty_end'      => optional($product->warranty_end)->format('m/d/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'product_name',
            'price',
            'category',
            'brand',
            'model',
            'serial_no',
            'project_serial_no',
            'position',
            'user_description',
            'remarks',
            'warranty_start',
            'warranty_end',
        ];
    }
}