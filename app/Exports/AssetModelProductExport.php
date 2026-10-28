<?php

namespace App\Exports;

use App\Models\AssetModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Services\ProductRowMapper;
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
        return Product::with(['category', 'brand', 'model'])
            ->where('model_id', $this->model->id)
            ->orderBy('id', 'desc');
    }

    public function map($product): array
    {
        return ProductRowMapper::mapRow($product);
    }

    public function headings(): array
    {
        return ProductRowMapper::headings();
    }

    public function title(): string
    {
        return $this->model->model_name;
    }
}
