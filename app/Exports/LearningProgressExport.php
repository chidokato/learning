<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LearningProgressExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Báo cáo đào tạo';
    }

    public function headings(): array
    {
        return [
            'Mã nv',
            'Họ tên',
            'Chức danh',
            'Phòng ban',
            'Email',
            'Mã khóa học',
            'Tên khóa học',
            'Thời gian học',
            'Tình trạng học',
            'Số lần thi',
            'Tình trạng thi',
            'Điểm thi',
            'Kết quả',
        ];
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->data as $item) {
            $score = $item['score'] ?? '';
            if (is_numeric($score)) {
                $scoreVal = (int) $score;
            } elseif ($score === '-' || empty($score)) {
                $scoreVal = '';
            } else {
                $scoreVal = (string) $score;
            }

            $attemptsCount = $item['attempts_count'] ?? 0;
            $attemptsVal = ($attemptsCount > 0) ? (int) $attemptsCount : 0;

            $rows[] = [
                $item['employee_code'] ?? '',
                $item['name'] ?? '',
                $item['job_title'] ?? '',
                $item['department'] ?? '',
                $item['email'] ?? '',
                $item['course_code'] ?? '',
                $item['course_title'] ?? '',
                $item['study_time'] ?? '',
                $item['learning_status'] ?? '',
                $attemptsVal,
                $item['attempt_status'] ?? '',
                $scoreVal,
                $item['result'] ?? '',
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        // Chiều cao tiêu đề
        $sheet->getRowDimension(1)->setRowHeight(32);

        // Header Cột A - E (Thông tin nhân viên: Vàng nhạt giống ảnh)
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'name' => 'Segoe UI',
                'bold' => true,
                'color' => ['rgb' => '6B4E00'],
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFF2CC'], // Màu vàng nhạt
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'C9B88A'],
                ],
            ],
        ]);

        // Header Cột F - M (Thông tin khóa học & thi: Xanh lá nhạt giống ảnh)
        $sheet->getStyle('F1:M1')->applyFromArray([
            'font' => [
                'name' => 'Segoe UI',
                'bold' => true,
                'color' => ['rgb' => '1B5E20'],
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9EAD3'], // Màu xanh lá nhạt
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '9DC297'],
                ],
            ],
        ]);

        $rowCount = count($this->data);
        if ($rowCount > 0) {
            $lastRow = $rowCount + 1;

            // Kẻ viền và căn chỉnh chung cho toàn bộ vùng dữ liệu
            $sheet->getStyle("A2:M{$lastRow}")->applyFromArray([
                'font' => [
                    'name' => 'Segoe UI',
                    'size' => 10.5,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D0D7DE'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Căn lề từng cột phù hợp nghiệp vụ:
            // Cột A (Mã nv): Căn giữa
            $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột B (Họ tên): Căn trái
            $sheet->getStyle("B2:B{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Cột C (Chức danh): Căn trái
            $sheet->getStyle("C2:C{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Cột D (Phòng ban): Căn trái
            $sheet->getStyle("D2:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Cột E (Email): Căn trái
            $sheet->getStyle("E2:E{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Cột F (Mã khóa học): Căn giữa
            $sheet->getStyle("F2:F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột G (Tên khóa học): Căn trái
            $sheet->getStyle("G2:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Cột H (Thời gian học): Căn giữa
            $sheet->getStyle("H2:H{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột I (Tình trạng học): Căn giữa
            $sheet->getStyle("I2:I{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột J (Số lần thi): Căn giữa
            $sheet->getStyle("J2:J{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột K (Tình trạng thi): Căn giữa
            $sheet->getStyle("K2:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột L (Điểm thi): Căn giữa
            $sheet->getStyle("L2:L{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột M (Kết quả): Căn giữa
            $sheet->getStyle("M2:M{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Duyệt từng dòng để định dạng chiều cao và màu chữ kết quả
            for ($r = 2; $r <= $lastRow; $r++) {
                $sheet->getRowDimension($r)->setRowHeight(24);

                $dataIdx = $r - 2;
                $rowItem = $this->data[$dataIdx] ?? [];

                // Tô màu theo kết quả thi
                $resultVal = $rowItem['result'] ?? '';
                if ($resultVal === 'Đạt') {
                    $sheet->getStyle("M{$r}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['rgb' => '0F5132']],
                    ]);
                } elseif ($resultVal === 'Không đạt') {
                    $sheet->getStyle("M{$r}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['rgb' => '842029']],
                    ]);
                }

                // Tình trạng học
                $learnVal = $rowItem['learning_status'] ?? '';
                if ($learnVal === 'Hoàn thành') {
                    $sheet->getStyle("I{$r}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['rgb' => '0F5132']],
                    ]);
                }
            }
        }

        return [];
    }
}
