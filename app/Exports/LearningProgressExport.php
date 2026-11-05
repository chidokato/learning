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
            'Công ty',
            'Phòng ban',
            'Email',
            'Mã khóa học',
            'Tên khóa học',
            'Thời gian học',
            'Tình trạng học',
            'Số lần thi',
            'Ngày thi',
            'Thời gian hoàn thành bài thi',
            'Điểm thi',
            'Kết quả',
        ];
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->data as $item) {
            $score = $item['score'] ?? '';
            if ($score === '-' || $score === null || $score === '') {
                $scoreVal = '-';
            } elseif (is_numeric($score)) {
                $scoreVal = (int) $score;
            } else {
                $scoreVal = (string) $score;
            }

            $attemptsCount = $item['attempts_count'] ?? 0;
            $attemptsVal = ($attemptsCount > 0) ? (int) $attemptsCount : 0;

            $rows[] = [
                $item['employee_code'] ?? '',
                $item['name'] ?? '',
                $item['job_title'] ?? '',
                $item['company'] ?? '-',
                $item['department'] ?? '',
                $item['email'] ?? '',
                $item['course_code'] ?? '',
                $item['course_title'] ?? '',
                $item['study_time'] ?? '',
                $item['learning_status'] ?? '',
                $attemptsVal,
                $item['test_date'] ?? '-',
                $item['test_duration'] ?? '-',
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

        // Header Cột A - F (Thông tin nhân viên: Vàng nhạt)
        $sheet->getStyle('A1:F1')->applyFromArray([
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

        // Header Cột G - O (Thông tin khóa học & thi: Xanh lá nhạt)
        $sheet->getStyle('G1:O1')->applyFromArray([
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
            $sheet->getStyle("A2:O{$lastRow}")->applyFromArray([
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
            // Cột D (Công ty): Căn trái
            $sheet->getStyle("D2:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Cột E (Phòng ban): Căn trái
            $sheet->getStyle("E2:E{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Cột F (Email): Căn trái
            $sheet->getStyle("F2:F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Cột G (Mã khóa học): Căn giữa
            $sheet->getStyle("G2:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột H (Tên khóa học): Căn trái
            $sheet->getStyle("H2:H{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            // Cột I (Thời gian học): Căn giữa
            $sheet->getStyle("I2:I{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột J (Tình trạng học): Căn giữa
            $sheet->getStyle("J2:J{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột K (Số lần thi): Căn giữa
            $sheet->getStyle("K2:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột L (Ngày thi): Căn giữa
            $sheet->getStyle("L2:L{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột M (Thời gian hoàn thành bài thi): Căn giữa
            $sheet->getStyle("M2:M{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Cột N (Điểm thi): Căn giữa và định dạng Text (tránh Excel tự nhận diện nhầm tỉ lệ phân số dạng 26/30 thành ngày tháng)
            $sheet->getStyle("N2:N{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("N2:N{$lastRow}")->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            // Cột O (Kết quả): Căn giữa
            $sheet->getStyle("O2:O{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Duyệt từng dòng để định dạng chiều cao và màu chữ kết quả
            for ($r = 2; $r <= $lastRow; $r++) {
                $sheet->getRowDimension($r)->setRowHeight(24);

                $dataIdx = $r - 2;
                $rowItem = $this->data[$dataIdx] ?? [];

                // Tô màu theo kết quả thi
                $resultVal = $rowItem['result'] ?? '';
                if ($resultVal === 'Đạt') {
                    $sheet->getStyle("O{$r}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['rgb' => '0F5132']],
                    ]);
                } elseif ($resultVal === 'Không đạt') {
                    $sheet->getStyle("O{$r}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['rgb' => '842029']],
                    ]);
                }

                // Tình trạng học
                $learnVal = $rowItem['learning_status'] ?? '';
                if ($learnVal === 'Hoàn thành') {
                    $sheet->getStyle("J{$r}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['rgb' => '0F5132']],
                    ]);
                }
            }
        }

        return [];
    }
}
