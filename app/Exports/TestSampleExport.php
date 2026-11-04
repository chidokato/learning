<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TestSampleExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'Cột A (Loại)',
            'Cột B (Nội dung câu hỏi / đáp án)',
            'Cột C (Đáp án đúng)',
        ];
    }

    public function array(): array
    {
        return [
            ['Câu 1', 'Thủ đô của Việt Nam là thành phố nào?', ''],
            ['A', 'Hà Nội', 'x'],
            ['B', 'Thành phố Hồ Chí Minh', ''],
            ['C', 'Đà Nẵng', ''],
            ['D', 'Cần Thơ', ''],
            ['Câu 2', 'Những thành phố nào sau đây trực thuộc Trung ương? (Nhiều đáp án)', ''],
            ['A', 'Hà Nội', 'x'],
            ['B', 'Hải Phòng', 'x'],
            ['C', 'Đà Nẵng', 'x'],
            ['D', 'Nha Trang', ''],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension(1)->setRowHeight(28);

        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => '1E3A8A'],
                    'size' => 11,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'DBEAFE'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '93C5FD'],
                    ],
                ],
            ],
        ];
    }
}
