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

class UserSampleExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'user',
            'pass',
            'Mã nv',
            'Họ tên',
            'Chức danh',
            'Phòng ban',
            'Email',
        ];
    }

    public function array(): array
    {
        return [
            [
                'thuythp',
                '123456',
                'DXMB001',
                'Phương Thúy',
                'Chuyên viên kinh doanh',
                'Phòng Kinh Doanh 1',
                'thuythp.idc@dxmb.vn',
            ],
            [
                'phucndv',
                '123456',
                'DXMB002',
                'Nguyễn Đình Vĩnh Phúc',
                'Trưởng nhóm',
                'Khối Kinh Doanh',
                'phucndv06.idc@gmail.com',
            ],
            [
                'tuannv',
                '123456',
                'DXMB003',
                'Nguyễn Văn Tuấn',
                'Giám đốc dự án',
                'Ban Giám Đốc',
                'tuan.nhadatvn@gmail.com',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension(1)->setRowHeight(28);

        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => '7B4A00'],
                    'size' => 11,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FCE8A6'], // Màu vàng nhạt giống mẫu của khách
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'B0A080'],
                    ],
                ],
            ],
        ];
    }
}
