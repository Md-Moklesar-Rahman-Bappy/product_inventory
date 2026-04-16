<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CategorySheetExport implements FromQuery, WithHeadings, WithMapping, WithTitle
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function query(): Builder
    {
        return Product::with(['category', 'brand', 'model'])
            ->where('category_id', $this->category->id)
            ->orderBy('id', 'desc');
    }

    public function map($product): array
    {
        return [
            $product->product_name,
            $product->price,
            $product->category?->category_name,
            $product->brand?->brand_name,
            $product->model?->model_name,
            $product->serial_no,
            $product->project_serial_no,
            $product->position,
            str_replace(["\r", "\n"], ' ', $product->user_description),
            str_replace(["\r", "\n"], ' ', $product->remarks),
            optional($product->warranty_start)->format('d/m/Y'),
            optional($product->warranty_end)->format('d/m/Y'),
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

    public function title(): string
    {
        return $this->category->category_name;
    }
}
