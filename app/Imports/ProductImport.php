<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'product_name'       => $row['product_name'],
            'category_id'        => $row['category_id'],
            'brand_id'           => $row['brand_id'],
            'model_id'           => $row['model_id'],
            'serial_no'          => strtoupper($row['serial_no']),
            'project_serial_no'  => strtoupper($row['project_serial_no']),
            'position'           => $row['position'],
            'user_description'   => $row['user_description'],
            'remarks'            => $row['remarks'],
            'warranty_start'     => $row['warranty_start'],
            'warranty_end'       => $row['warranty_end'],
        ]);
    }
}
