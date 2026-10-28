<?php

namespace App\Services;

use App\Models\Product;

class ProductRowMapper
{
    public const HEADINGS = [
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

    public static function headings(): array
    {
        return self::HEADINGS;
    }

    public static function mapRow(Product $product): array
    {
        return [
            'product_name' => $product->product_name ?? '',
            'price' => $product->price ?? 0,
            'category' => $product->category?->category_name ?? '',
            'brand' => $product->brand?->brand_name ?? '',
            'model' => $product->model?->model_name ?? '',
            'serial_no' => $product->serial_no ?? '',
            'project_serial_no' => $product->project_serial_no ?? '',
            'position' => $product->position ?? '',
            'user_description' => $product->user_description ? str_replace(["\r", "\n"], ' ', $product->user_description) : '',
            'remarks' => $product->remarks ? str_replace(["\r", "\n"], ' ', $product->remarks) : '',
            'warranty_start' => optional($product->warranty_start)->format('d/m/Y') ?? '',
            'warranty_end' => optional($product->warranty_end)->format('d/m/Y') ?? '',
        ];
    }

    public static function formatForCsv(Product $product): array
    {
        return [
            $product->product_name ?? '',
            $product->price ?? 0,
            $product->category?->category_name ?? '',
            $product->brand?->brand_name ?? '',
            $product->model?->model_name ?? '',
            $product->serial_no ?? '',
            $product->project_serial_no ?? '',
            $product->position ?? '',
            $product->user_description ? str_replace(["\r", "\n"], ' ', $product->user_description) : '',
            $product->remarks ? str_replace(["\r", "\n"], ' ', $product->remarks) : '',
            optional($product->warranty_start)->format('d/m/Y') ?? '',
            optional($product->warranty_end)->format('d/m/Y') ?? '',
        ];
    }
}
