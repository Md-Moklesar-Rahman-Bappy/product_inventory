<?php

namespace App\Exports;

use App\Services\ProductRowMapper;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class ProductSampleDataSheet implements FromArray, WithHeadings, WithTitle, WithMapping, WithColumnFormatting, WithColumnWidths, WithEvents
{
    public function array(): array
    {
        return [
            [
                'ProBook 440 G11 Notebook PC',
                157285,
                'Laptop',
                'HP',
                'ProBook 440 G11 Notebook PC',
                'SAMPLE-EN-001',
                'SAMPLE/PROJECT/001',
                'ICT Section',
                'Assigned to maintenance team',
                'Sample English record',
                '30/05/2025',
                '30/05/2026',
            ],
            [
                'পরীক্ষামূলক ল্যাপটপ',
                150000,
                'ল্যাপটপ',
                'এইচপি',
                'পরীক্ষামূলক মডেল',
                'SAMPLE-BN-001',
                'SAMPLE/BN/001',
                'প্রকল্প পরিচালকের কক্ষ',
                'সহকারী রক্ষণাবেক্ষণ প্রকৌশলীর জন্য বরাদ্দ',
                'বাংলা ইউনিকোড পরীক্ষার নমুনা',
                '30/05/2025',
                '30/05/2026',
            ],
        ];
    }

    public function headings(): array
    {
        return ProductRowMapper::headings();
    }

    public function title(): string
    {
        return 'Sample Products';
    }

    public function map($row): array
    {
        return $row;
    }

    public function columnFormats(): array
    {
        return [
            'F' => '@',
            'G' => '@',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 15,
            'C' => 20,
            'D' => 20,
            'E' => 30,
            'F' => 25,
            'G' => 30,
            'H' => 30,
            'I' => 35,
            'J' => 30,
            'K' => 18,
            'L' => 18,
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->getSheet()->getDelegate();
                $sheet->freezePane('A2');
                $sheet->getStyle('A1:L1')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
                $sheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('2c3e50');
            },
        ];
    }
}
