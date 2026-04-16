<?php

namespace App\Exports;

use App\Models\AssetModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AssetModelProductExport implements FromQuery, WithHeadings, WithMapping, WithTitle
{
    protected $model;

    public function __construct($modelId)
    {
        $this->model = AssetModel::findOrFail($modelId);
    }

    public function query(): Builder
    {
        return Product::with(['brand', 'category'])
            ->where('model_id', $this->model->id)
            ->orderBy('id', 'desc');
    }

    public function map($product): array
    {
        return [
            $product->product_name,
            '৳ '.number_format($product->price, 2),
            $product->brand?->brand_name,
            $this->model->model_name,
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
        return $this->model->model_name;
    }
}
