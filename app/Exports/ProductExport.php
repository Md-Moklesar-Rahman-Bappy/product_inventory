<?php

namespace App\Exports;

use App\Models\Product;
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
        return [
            'product_name' => $product->product_name,
            'price' => $product->price,
            'category' => $product->category?->category_name,
            'brand' => $product->brand?->brand_name,
            'model' => $product->model?->model_name,
            'serial_no' => $product->serial_no,
            'project_serial_no' => $product->project_serial_no,
            'position' => $product->position,
            'user_description' => str_replace(["\r", "\n"], ' ', $product->user_description),
            'remarks' => str_replace(["\r", "\n"], ' ', $product->remarks),
            'warranty_start' => optional($product->warranty_start)->format('d/m/Y'),
            'warranty_end' => optional($product->warranty_end)->format('d/m/Y'),
        ];
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
