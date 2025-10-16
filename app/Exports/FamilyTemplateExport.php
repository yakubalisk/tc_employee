<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FamilyTemplateExport implements FromArray, WithHeadings, WithTitle, WithStrictNullComparison, WithEvents
{
    public function array(): array
    {
        return [
            [
                '786786',            // empID
                'NACHIKET',     // name_of_family_member
                'Son',          // relationship
                '25-Jan-06',    // date_of_birth
                'DEPENDENT',    // dependent_remarks
                '',             // reason_for_dependence
                'No',           // ltc
                'No',           // medical
                'No',           // gsli
                'No',           // gpf
                'No',           // dcrg
                'No'            // pension_nps
            ],
            [
                '555555',
                'VARSHA',
                'Wife',
                '22-Oct-81',
                'DEPENDENT',
                '',
                'No',
                'No',
                'No',
                'No',
                'No',
                'No'
            ],
            [
                '123456',
                'GEETANJALI A KAKAD',
                'Wife',
                '07-Jan-67',
                'Dependent',
                'HOUSE WIFE',
                'No',
                'No',
                'No',
                'No',
                'No',
                'No'
            ],
            [
                '444444',
                'ABHISHEK A KAKAD',
                'Son',
                '05-Jan-99',
                'Dependent',
                'MINOR',
                'No',
                'No',
                'No',
                'No',
                'No',
                'No'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'emp_code',
            'name_of_family_member',
            'relationship',
            'date_of_birth',
            'dependent_remarks',
            'reason_for_dependence',
            'ltc',
            'medical',
            'gsli',
            'gpf',
            'dcrg',
            'pension_nps'
        ];
    }

    public function title(): string
    {
        return 'Family Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto-size columns for better readability
                $columns = [
                    'A' => 10, 'B' => 20, 'C' => 15, 'D' => 15,
                    'E' => 20, 'F' => 20, 'G' => 8, 'H' => 8,
                    'I' => 8, 'J' => 8, 'K' => 8, 'L' => 12
                ];
                
                foreach ($columns as $column => $width) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setWidth($width);
                }

                // Style the header row
                $event->sheet->getStyle('A1:L1')->applyFromArray([
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
                $event->sheet->getStyle('A2:L5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                // Add data validation notes
                $event->sheet->setCellValue('N1', 'Data Validation Notes:');
                $event->sheet->setCellValue('N2', 'date_of_birth: Use DD-MMM-YY format (e.g., 25-Jan-06)');
                $event->sheet->setCellValue('N3', 'relationship: Wife, Husband, Son, Daughter, etc.');
                $event->sheet->setCellValue('N4', 'Boolean fields (LTC, Medical, etc.): Yes/No or True/False');
                $event->sheet->setCellValue('N5', 'Age will be calculated automatically from date of birth');
                $event->sheet->setCellValue('N6', 'dependent_remarks: DEPENDENT, Dependent, etc.');
                $event->sheet->setCellValue('N7', 'reason_for_dependence: HOUSE WIFE, NO INCOME, MINOR, etc.');

                // Style the notes section
                $event->sheet->getStyle('N1:N7')->applyFromArray([
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
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(35);
            },
        ];
    }
}