<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DoctorTemplateExport implements FromArray, WithHeadings, WithTitle, WithStrictNullComparison, WithEvents
{
    public function array(): array
    {
        return [
            [
                '786786',                                                    // empID
                'DR GAUTAM R SHAH',                                     // name_of_doctor
                '9812',                                                 // registration_no
                'GROUND FLOOR, KHANPUR, AHMEDABAD',                     // address
                'MBBS',                                                 // qualification
                ''                                                      // ama_remarks
            ],
            [
                '555555',
                'DR RAMESH KHATIWALA',
                'G-7543',
                'BEHIND OLD CIVIL HOSPITAL SURAT 395001',
                'MBBS',
                ''
            ],
            [
                '444444',
                '',
                '',
                '.',
                '',
                'GAGANDEEP HAWA SINGH'
            ],
            [
                '123456',
                'ATUL JAIMINI',
                'DMC-49529, MCI-19367',
                'GEMINI HOSPITAL GOHANA ROAD SONIPAT HARYANA',
                'DNB CARDIOLOGY',
                'NARENDER SINGH'
            ],
            [
                '888888',
                'DR. ANUNAY DHONDIYAL',
                '20308',
                'MAYUR VIHAR-III, DELHI 110096',
                'BAMS',
                'AMA1'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'emp_code',
            'name_of_doctor',
            'registration_no',
            'address',
            'qualification',
            'ama_remarks'
        ];
    }

    public function title(): string
    {
        return 'Doctor Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto-size columns for better readability
                $columns = [
                    'A' => 10, 'B' => 25, 'C' => 20, 'D' => 35,
                    'E' => 20, 'F' => 20
                ];
                
                foreach ($columns as $column => $width) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setWidth($width);
                }

                // Style the header row
                $event->sheet->getStyle('A1:F1')->applyFromArray([
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
                $event->sheet->getStyle('A2:F6')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                // Add data validation notes
                $event->sheet->setCellValue('H1', 'Data Validation Notes:');
                $event->sheet->setCellValue('H2', 'empID: Required field');
                $event->sheet->setCellValue('H3', 'name_of_doctor: Optional (can be left blank)');
                $event->sheet->setCellValue('H4', 'registration_no: Optional registration number');
                $event->sheet->setCellValue('H5', 'address: Full address of the doctor');
                $event->sheet->setCellValue('H6', 'qualification: MBBS, BAMS, MD, DNB, etc.');
                $event->sheet->setCellValue('H7', 'ama_remarks: AMA related remarks');

                // Style the notes section
                $event->sheet->getStyle('H1:H7')->applyFromArray([
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
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(35);
            },
        ];
    }
}