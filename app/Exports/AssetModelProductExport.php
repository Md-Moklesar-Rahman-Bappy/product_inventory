<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\AssetModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AssetModelProductExport implements FromCollection, WithHeadings, WithTitle
{
    protected $model;

    public function __construct($modelId)
    {
        $this->model = AssetModel::findOrFail($modelId);
    }

    public function collection(): Collection
    {
        return Product::with(['brand', 'category'])
            ->where('model_id', $this->model->id)
            ->get()
            ->map(function ($product) {
                return [
                    $product->product_name,
                    '৳ ' . number_format($product->price, 2),
                    $product->brand?->brand_name,
                    $this->model->model_name,
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
        return $this->model->model_name;
    }
}
