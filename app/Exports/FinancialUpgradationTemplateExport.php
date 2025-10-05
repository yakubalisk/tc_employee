<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinancialUpgradationTemplateExport implements FromArray, WithHeadings, WithTitle, WithStrictNullComparison, WithEvents
{
    public function array(): array
    {
        return [
            [
                '1',                    // sr_no
                '4',                    // empl_id
                '05-Nov-2011',          // promotion_date
                'JQAO (LAB)',           // existing_designation
                'QAO (LAB)',            // upgraded_designation
                '05-Nov-2001',          // date_in_grade
                '5200-20200 GP 2800',   // existing_scale
                '9300-34800 GP 4200',   // upgraded_scale
                'YES',                  // pay_fixed
                '11680',                // existing_pay
                '2800',                 // existing_grade_pay
                '12120',                // upgraded_pay
                '4200',                 // upgraded_grade_pay
                '',                     // macp_remarks
                '1',                    // no_of_financial_upgradation
                'MACP',                 // financial_upgradation_type
                'north',                // region
                'lab'                   // department
            ],
            [
                '2',
                '15',
                '12-Mar-2013',
                'Assistant Manager',
                'Manager',
                '12-Mar-2008',
                '9300-34800 GP 4200',
                '15600-39100 GP 5400',
                'YES',
                '18500',
                '4200',
                '22500',
                '5400',
                'Regular promotion',
                '1',
                'PROMOTION',
                'south',
                'finance'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'sr_no',
            'empl_id',
            'promotion_date',
            'existing_designation',
            'upgraded_designation',
            'date_in_grade',
            'existing_scale',
            'upgraded_scale',
            'pay_fixed',
            'existing_pay',
            'existing_grade_pay',
            'upgraded_pay',
            'upgraded_grade_pay',
            'macp_remarks',
            'no_of_financial_upgradation',
            'financial_upgradation_type',
            'region',
            'department'
        ];
    }

    public function title(): string
    {
        return 'Financial Upgradation Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto-size columns for better readability
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(8);  // sr_no
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(12); // empl_id
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15); // promotion_date
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20); // existing_designation
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20); // upgraded_designation
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(15); // date_in_grade
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25); // existing_scale
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25); // upgraded_scale
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(12); // pay_fixed
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(15); // existing_pay
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(18); // existing_grade_pay
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(15); // upgraded_pay
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(18); // upgraded_grade_pay
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(25); // macp_remarks
                $event->sheet->getDelegate()->getColumnDimension('O')->setWidth(25); // no_of_financial_upgradation
                $event->sheet->getDelegate()->getColumnDimension('P')->setWidth(25); // financial_upgradation_type
                $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(12); // region
                $event->sheet->getDelegate()->getColumnDimension('R')->setWidth(15); // department

                // Style the header row
                $event->sheet->getStyle('A1:R1')->applyFromArray([
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
                $event->sheet->getStyle('A2:R3')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                // Add data validation notes
                $event->sheet->setCellValue('T1', 'Data Validation Notes:');
                $event->sheet->setCellValue('T2', 'pay_fixed: YES/NO');
                $event->sheet->setCellValue('T3', 'financial_upgradation_type: MACP/PROMOTION/ACP');
                $event->sheet->setCellValue('T4', 'region: north/south/east/west');
                $event->sheet->setCellValue('T5', 'department: finance/hr/it/operations/lab');
                $event->sheet->setCellValue('T6', 'Dates should be in DD-MMM-YYYY format');
                $event->sheet->setCellValue('T7', 'Pay values should be numeric');

                // Style the notes section
                $event->sheet->getStyle('T1:T7')->applyFromArray([
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
                $event->sheet->getDelegate()->getColumnDimension('T')->setWidth(30);
            },
        ];
    }
}