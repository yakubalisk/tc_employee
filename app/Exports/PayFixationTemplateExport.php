<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PayFixationTemplateExport implements FromArray, WithHeadings, WithTitle, WithStrictNullComparison, WithEvents
{
    public function array(): array
    {
        return [
            [
                '123456',          // empl_id
                '01-Jan-16',    // pay_fixation_date
                '77700',        // basic_pay
                '',             // grade_pay
                '12',           // cell_no
                'Level 10',     // revised_level
                '',             // pay_fixation_remarks
                '10'            // level_2
            ],
            [
                '555555',
                '01-Jan-16',
                '83300',
                '',
                '8',
                'Level 11',
                '',
                '11'
            ],
            [
                '786786',
                '01-Jan-16',
                '38700',
                '',
                '4',
                'Level 6',
                '',
                '6'
            ],
            [
                '123456',
                '01-Jan-16',
                '40400',
                '',
                '12',
                'Level 5',
                '',
                '5'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'emp_code',
            'pay_fixation_date',
            'basic_pay',
            'grade_pay',
            'cell_no',
            'revised_level',
            'pay_fixation_remarks',
            'level_2'
        ];
    }

    public function title(): string
    {
        return 'Pay Fixation Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto-size columns for better readability
                $columns = [
                    'A' => 12, 'B' => 18, 'C' => 12, 'D' => 12,
                    'E' => 10, 'F' => 15, 'G' => 25, 'H' => 10
                ];
                
                foreach ($columns as $column => $width) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setWidth($width);
                }

                // Style the header row
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => '2E86C1'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Style the data rows
                $event->sheet->getStyle('A2:H5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                // Add data validation notes
                $event->sheet->setCellValue('J1', 'Data Validation Notes:');
                $event->sheet->setCellValue('J2', 'pay_fixation_date: Use DD-MMM-YY format (e.g., 01-Jan-16)');
                $event->sheet->setCellValue('J3', 'basic_pay & grade_pay: Numeric values only');
                $event->sheet->setCellValue('J4', 'cell_no: Integer values only');
                $event->sheet->setCellValue('J5', 'revised_level: Level 1 to Level 14');
                $event->sheet->setCellValue('J6', 'level_2: 1 to 14');
                $event->sheet->setCellValue('J7', 'grade_pay: Can be left blank if not applicable');

                // Style the notes section
                $event->sheet->getStyle('J1:J7')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '333333'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'F8F9FA'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                // Auto-size the notes column
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(40);
            },
        ];
    }
}