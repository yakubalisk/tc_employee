<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AparTemplateExport implements FromArray, WithHeadings, WithTitle, WithStrictNullComparison, WithEvents
{
    public function array(): array
    {
        return [
            ['334', 'April', '2016', 'March', '2017', 'APAR', '', '8.4', '8.4', 'A', 'A+', 'FALSE', ''],
            ['334', 'April', '2015', 'March', '2016', 'APAR', '', '9.3', '9.3', 'B', 'B+', 'FALSE', '']
        ];
    }

public function headings(): array
{
    return [
        'empl_id',
        'from_month', 
        'from_year',
        'to_month',
        'to_year',
        'grading_type',
        'discrepancy_remarks',
        'reporting_marks',
        'reviewing_marks', 
        'reporting_grade',
        'reviewing_grade',
        'consideration',
        'remarks'
    ];
}

    public function title(): string
    {
        return 'APAR Import Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto-size columns for better readability
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(18);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(25);

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
                ]);
            },
        ];
    }
}