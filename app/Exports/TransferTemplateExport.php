<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TransferTemplateExport implements FromArray, WithHeadings, WithTitle, WithStrictNullComparison, WithEvents
{
    public function array(): array
    {
        return [
            [
                '4',                                // empID
                'JQAO (LAB)',                       // designation
                '01-Nov-01',                        // date_of_joining
                '28-Jan-02',                        // date_of_releiving
                '28/4/2001/AD DATED 11.01.2002',    // transfer_order_no
                '',                                 // transfer_remarks
                'MUMBAI',                           // region
                '',                                 // date_of_exit
                '',                                 // duration
                'LAB',                              // department_worked
                'BANGALORE'                         // transferred_region
            ],
            [
                '4',
                'JQAO (LAB)',
                '10-Jun-13',
                '13-Jul-18',
                '28/1/2018/AD DATED 28.06.2018',
                '',
                'AHMEDABAD',
                '',
                '',
                'LAB',
                'MUMBAI'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'empID',
            'designation',
            'date_of_joining',
            'date_of_releiving',
            'transfer_order_no',
            'transfer_remarks',
            'region',
            'date_of_exit',
            'duration',
            'department_worked',
            'transferred_region'
        ];
    }

    public function title(): string
    {
        return 'Transfer Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto-size columns for better readability
                $columns = [
                    'A' => 10, 'B' => 15, 'C' => 15, 'D' => 15,
                    'E' => 30, 'F' => 20, 'G' => 12, 'H' => 15,
                    'I' => 12, 'J' => 18, 'K' => 18
                ];
                
                foreach ($columns as $column => $width) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setWidth($width);
                }

                // Style the header row
                $event->sheet->getStyle('A1:K1')->applyFromArray([
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
                $event->sheet->getStyle('A2:K3')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                // Add data validation notes
                $event->sheet->setCellValue('M1', 'Data Validation Notes:');
                $event->sheet->setCellValue('M2', 'Dates: Use DD-MMM-YY format (e.g., 01-Nov-01)');
                $event->sheet->setCellValue('M3', 'designation: JQAO (LAB), QAO (EP&QA), etc.');
                $event->sheet->setCellValue('M4', 'region & transferred_region: MUMBAI, BANGALORE, etc.');
                $event->sheet->setCellValue('M5', 'department_worked: LAB, EP&QA, etc.');
                $event->sheet->setCellValue('M6', 'duration: Will be calculated automatically if left blank');
                $event->sheet->setCellValue('M7', 'date_of_exit: Optional field');

                // Style the notes section
                $event->sheet->getStyle('M1:M7')->applyFromArray([
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
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(35);
            },
        ];
    }
}