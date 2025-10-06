<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ModeOfRecruitmentTemplateExport implements FromArray, WithHeadings, WithTitle, WithStrictNullComparison, WithEvents
{
    public function array(): array
    {
        return [
            [
                '288',                      // empID
                'STAFF CAR DRIVER II',      // Designation_
                '2',                        // Seniority_Number
                'STAFF CAR DRIVER II',      // Designation
                '25-06-2025',               // Date_of_Entry
                '29/74/96/AD dated 24.06.2025', // Office_Order_No
                'PR',                       // Method_of_Recruitment
                '',                         // Promotion_Remarks
                'Yes',                      // Pay_Fixation
                '',                         // Date_of_Exit
                '',                         // GSLI_Policy_No
                '',                         // GSLI_Entry_dt
                ''                          // GSLI_Exit_dt
            ],
            [
                '289',
                'STAFF CAR DRIVER II',
                '3',
                'STAFF CAR DRIVER II',
                '25-06-2025',
                '29/74/96/AD dated 24.06.2025',
                'PR',
                '',
                'Yes',
                '',
                '',
                '',
                ''
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'empID',
            'Designation_',
            'Seniority_Number',
            'Designation',
            'Date_of_Entry',
            'Office_Order_No',
            'Method_of_Recruitment',
            'Promotion_Remarks',
            'Pay_Fixation',
            'Date_of_Exit',
            'GSLI_Policy_No',
            'GSLI_Entry_dt',
            'GSLI_Exit_dt'
        ];
    }

    public function title(): string
    {
        return 'Mode of Recruitment Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto-size columns for better readability
                $columns = [
                    'A' => 10, 'B' => 20, 'C' => 18, 'D' => 20, 'E' => 15,
                    'F' => 30, 'G' => 22, 'H' => 25, 'I' => 12, 'J' => 15,
                    'K' => 18, 'L' => 15, 'M' => 15
                ];
                
                foreach ($columns as $column => $width) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setWidth($width);
                }

                // Style the header row
                $event->sheet->getStyle('A1:M1')->applyFromArray([
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
                $event->sheet->getStyle('A2:M3')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                // Add data validation notes
                $event->sheet->setCellValue('O1', 'Data Validation Notes:');
                $event->sheet->setCellValue('O2', 'Method_of_Recruitment: PR, DIRECT, DEPUTATION, CONTRACT');
                $event->sheet->setCellValue('O3', 'Pay_Fixation: Yes, No');
                $event->sheet->setCellValue('O4', 'Dates should be in DD-MM-YYYY format');
                $event->sheet->setCellValue('O5', 'Seniority_Number should be numeric');
                $event->sheet->setCellValue('O6', 'Leave empty fields blank for optional fields');

                // Style the notes section
                $event->sheet->getStyle('O1:O6')->applyFromArray([
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
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(35);
            },
        ];
    }
}