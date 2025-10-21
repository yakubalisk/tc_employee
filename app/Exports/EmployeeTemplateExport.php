<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeeTemplateExport implements FromArray, WithHeadings, WithTitle, WithStrictNullComparison, WithEvents
{
    public function array(): array
    {
        return [
            [
                'EMP001',                   // emp_code
                'Rajesh Kumar',             // name
                'MALE',                     // gender
                'General',                  // category
                'B.Tech Computer Science',  // education
                '9876543210',               // mobile
                'rajesh.kumar@example.com', // email
                '15-Jan-2020',              // date_of_appointment
                'Software Engineer',        // designation_at_appointment
                'Senior Software Engineer', // designation_at_present
                'Headquarters',             // present_posting
                'PFN001',                   // personal_file_no
                '011-23456789',             // office_landline
                '15-Mar-1990',              // date_of_birth
                '15-Mar-2050',              // date_of_retirement
                'Delhi',                    // home_town
                'A-123, ABC Colony, Delhi', // residential_address
                'EXISTING',                 // status
                'No',                       // office_in_charge
                'Yes',                      // nps
                'No',                       // probation_period
                'Yes',                      // department
                'Yes',                      // karmayogi_certificate_completed
                'Promotee',                 // promotee_transferee
                'PEN001',                   // pension_file_no
                '4',                        // increment_month
                'Filled',                   // status_of_post
                'SEQ001',                   // seniority_sequence_no
                'Section A',                // sddlsection_incharge
                'Yes',                      // benevolent_member
                '011-23456780'              // office_landline_number
            ],
            [
                'EMP002',
                'Priya Sharma',
                'FEMALE',
                'OBC',
                'MBA Marketing',
                '9876543211',
                'priya.sharma@example.com',
                '20-Mar-2019',
                'Marketing Executive',
                'Marketing Manager',
                'Regional Office',
                'PFN002',
                '011-23456790',
                '20-Aug-1988',
                '20-Aug-2048',
                'Mumbai',
                'B-456, XYZ Society, Mumbai',
                'EXISTING',
                'Yes',
                'Yes',
                'No',
                'Yes',
                'No',
                'Transferee',
                'PEN002',
                '6',
                'Vacant',
                'SEQ002',
                'Section B',
                'No',
                '011-23456791'
            ],
            [
                'EMP003',
                'Amit Singh',
                'MALE',
                'SC',
                'B.Com',
                '9876543212',
                'amit.singh@example.com',
                '10-Jun-2018',
                'Accountant',
                'Senior Accountant',
                'Finance Department',
                'PFN003',
                '011-23456792',
                '10-Dec-1985',
                '10-Dec-2045',
                'Kolkata',
                'C-789, PQR Lane, Kolkata',
                'EXISTING',
                'No',
                'No',
                'No',
                'Yes',
                'No',
                'Promotee',
                'PEN003',
                '3',
                'Filled',
                'SEQ003',
                'Section C',
                'Yes',
                '011-23456793'
            ],
            [
                'EMP004',
                'Sunita Patel',
                'FEMALE',
                'ST',
                'M.Sc Chemistry',
                '9876543213',
                'sunita.patel@example.com',
                '05-Sep-2021',
                'Lab Assistant',
                'Lab Technician',
                'Research Wing',
                'PFN004',
                '011-23456794',
                '05-Feb-1992',
                '05-Feb-2052',
                'Chennai',
                'D-321, LMN Street, Chennai',
                'EXISTING',
                'No',
                'Yes',
                'Yes',
                'No',
                'No',
                '',
                'PEN004',
                '7',
                'Temporary',
                'SEQ004',
                'Section D',
                'No',
                '011-23456795'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'emp_code',
            'name',
            'gender',
            'category',
            'education',
            'mobile',
            'email',
            'date_of_appointment',
            'designation_at_appointment',
            'designation_at_present',
            'present_posting',
            'personal_file_no',
            'office_landline',
            'date_of_birth',
            'date_of_retirement',
            'home_town',
            'residential_address',
            'status',
            'office_in_charge',
            'nps',
            'probation_period',
            'department',
            'karmayogi_certificate_completed',
            'promotee_transferee',
            'pension_file_no',
            'increment_month',
            'status_of_post',
            'seniority_sequence_no',
            'sddlsection_incharge',
            'benevolent_member',
            'office_landline_number'
        ];
    }

    public function title(): string
    {
        return 'Employee Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Auto-size columns for better readability
                $columns = [
                    'A' => 12,  'B' => 20,  'C' => 10,  'D' => 12,
                    'E' => 20,  'F' => 15,  'G' => 25,  'H' => 18,
                    'I' => 22,  'J' => 22,  'K' => 18,  'L' => 15,
                    'M' => 15,  'N' => 18,  'O' => 18,  'P' => 15,
                    'Q' => 25,  'R' => 12,  'S' => 15,  'T' => 8,
                    'U' => 15,  'V' => 12,  'W' => 25,  'X' => 18,
                    'Y' => 15,  'Z' => 15,  'AA' => 15, 'AB' => 20,
                    'AC' => 18, 'AD' => 18, 'AE' => 20
                ];
                
                foreach ($columns as $column => $width) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setWidth($width);
                }

                // Style the header row
                $headerRange = 'A1:AE1';
                $event->sheet->getStyle($headerRange)->applyFromArray([
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
                    'alignment' => [
                        'wrapText' => true,
                    ],
                ]);

                // Style the data rows
                $dataRange = 'A2:AE5';
                $event->sheet->getStyle($dataRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                    'alignment' => [
                        'wrapText' => true,
                    ],
                ]);

                // Add data validation notes
                $event->sheet->setCellValue('AG1', 'DATA VALIDATION NOTES:');
                $event->sheet->setCellValue('AG2', 'REQUIRED FIELDS:');
                $event->sheet->setCellValue('AG3', '• emp_code, name, gender, category');
                $event->sheet->setCellValue('AG4', '• date_of_appointment, designation_at_appointment');
                $event->sheet->setCellValue('AG5', '• designation_at_present, present_posting');
                $event->sheet->setCellValue('AG6', '• date_of_birth, date_of_retirement, status');
                
                $event->sheet->setCellValue('AG8', 'GENDER OPTIONS:');
                $event->sheet->setCellValue('AG9', 'MALE, FEMALE, OTHER');
                
                $event->sheet->setCellValue('AG11', 'CATEGORY OPTIONS:');
                $event->sheet->setCellValue('AG12', 'General, OBC, SC, ST');
                
                $event->sheet->setCellValue('AG14', 'STATUS OPTIONS:');
                $event->sheet->setCellValue('AG15', 'EXISTING, RETIRED, TRANSFERRED');
                
                $event->sheet->setCellValue('AG17', 'DATE FORMATS:');
                $event->sheet->setCellValue('AG18', 'DD-MMM-YYYY (15-Jan-2020)');
                $event->sheet->setCellValue('AG19', 'DD/MM/YYYY, MM/DD/YYYY');
                $event->sheet->setCellValue('AG20', 'YYYY-MM-DD, Excel serial dates');
                
                $event->sheet->setCellValue('AG22', 'BOOLEAN FIELDS:');
                $event->sheet->setCellValue('AG23', 'Yes/No, True/False, 1/0, Y/N');
                
                $event->sheet->setCellValue('AG25', 'INCREMENT MONTH:');
                $event->sheet->setCellValue('AG26', '1-12 or January-December');
                
                $event->sheet->setCellValue('AG28', 'MOBILE NUMBER:');
                $event->sheet->setCellValue('AG29', '10 digits only (auto-cleaned)');

                // Style the notes section
                $notesRange = 'AG1:AK30';
                $event->sheet->getStyle($notesRange)->applyFromArray([
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
                    'alignment' => [
                        'wrapText' => true,
                    ],
                ]);

                // Auto-size the notes columns
                $event->sheet->getDelegate()->getColumnDimension('AG')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AH')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AI')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AJ')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('AK')->setWidth(25);

                // Make header row bold and specific cells
                $event->sheet->getStyle('AG1')->getFont()->setBold(true);
                $event->sheet->getStyle('AG2')->getFont()->setBold(true);
                $event->sheet->getStyle('AG8')->getFont()->setBold(true);
                $event->sheet->getStyle('AG11')->getFont()->setBold(true);
                $event->sheet->getStyle('AG14')->getFont()->setBold(true);
                $event->sheet->getStyle('AG17')->getFont()->setBold(true);
                $event->sheet->getStyle('AG22')->getFont()->setBold(true);
                $event->sheet->getStyle('AG25')->getFont()->setBold(true);
                $event->sheet->getStyle('AG28')->getFont()->setBold(true);

                // Freeze the header row for better navigation
                $event->sheet->getDelegate()->freezePane('A2');
            },
        ];
    }
}