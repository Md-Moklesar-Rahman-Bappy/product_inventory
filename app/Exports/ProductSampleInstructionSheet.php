<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductSampleInstructionSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        return [
            ['Instruction', 'Details'],
            ['Headings', 'Use the exact headings shown on the Sample Products sheet.'],
            ['Required fields', 'product_name, price, category, brand, model, serial_no, project_serial_no'],
            ['Optional fields', 'position, user_description, remarks, warranty_start, warranty_end'],
            ['Position', 'Text value (e.g., ICT Section, প্রকল্প পরিচালকের কক্ষ) — never numeric'],
            ['Price', 'Positive number; zero is allowed only if business rules permit'],
            ['Dates', 'Use d/m/Y format: 30/05/2025'],
            ['Serial numbers', 'Text only — do not use formulas or scientific notation'],
            ['Bangla text', 'Fully supported in all text fields'],
            ['Import format', 'Save as .xlsx for best Unicode reliability'],
            ['CSV note', 'Only UTF-8 CSV is supported; include BOM for Excel compatibility'],
            ['Lookup values', 'Category, brand, and model names must exist or will be created automatically'],
        ];
    }

    public function title(): string
    {
        return 'Instructions';
    }
}
