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
                'QAO (LAB)',                // designation_at_appointment
                'ASST. DIRECTOR (LAB)',     // designation_at_present
                'DELHI - NCR',              // present_posting
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
                'JQAO (LAB)',
                'DY. DIRECTOR (LAB)',
                'MUMBAI',
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
                $sheet = $event->sheet->getDelegate();

                // Auto-size columns for better readability
                $columns = [
                    'A' => 12,  'B' => 20,  'C' => 12,  'D' => 12,
                    'E' => 20,  'F' => 15,  'G' => 25,  'H' => 18,
                    'I' => 25,  'J' => 25,  'K' => 20,  'L' => 15,
                    'M' => 15,  'N' => 18,  'O' => 18,  'P' => 15,
                    'Q' => 25,  'R' => 12,  'S' => 15,  'T' => 10,
                    'U' => 15,  'V' => 12,  'W' => 25,  'X' => 18,
                    'Y' => 15,  'Z' => 15,  'AA' => 15, 'AB' => 20,
                    'AC' => 18, 'AD' => 18, 'AE' => 20
                ];
                
                foreach ($columns as $column => $width) {
                    $sheet->getColumnDimension($column)->setWidth($width);
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
                $dataRange = 'A2:AE3';
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

                // Add dropdown lists
                $this->addDropdownLists($sheet, $event);

                // Add validation notes
                $this->addValidationNotes($event);

                // Freeze the header row for better navigation
                $sheet->freezePane('A2');
            },
        ];
    }

    private function addDropdownLists($sheet, $event)
    {
        // Define the options for each dropdown
        $dropdownOptions = [
            'C' => ['MALE', 'FEMALE', 'OTHER'], // Gender
            'D' => ['General', 'OBC', 'SC', 'ST'], // Category
            'I' => [ // Designation at appointment
                'QAO (LAB)', 'JQAO (LAB)', 'SECRETARY', 'FIELD OFFICER', 'SSA', 'ASST. SECRETARY',
                'QAO (EP&QA)', 'PUNCH OPERATOR', 'VIGILANCE OFFICER', 'JSA', 'CHIEF ACCOUNT OFFICER',
                'ACCOUNTANT', 'JR.INVESTIGATOR', 'ACCOUNTS OFFICER', 'SUPERINTENDENT', 'DIRECTOR (EP&QA)',
                'ASST. DIRECTOR (OL)', 'ASSISTANT', 'JT. DIRECTOR (EP&QA)', 'SR.TRANSLATOR', 'JR.TRANSLATOR',
                'DY. DIRECTOR (EP&QA)', 'SR.STENO', 'LIBRARIAN', 'ASST. DIRECTOR (EP&QA)', 'JR.STENO',
                'DIRECTOR (CDP)', 'UDC', 'DIRECTOR (TQM)', 'MAINTENANCE MECHANIC', 'DIRECTOR (LAB)', 'LDC',
                'JT. DIRECTOR (LAB)', 'STAFF CAR DRIVER I', 'DY. DIRECTOR (LAB)', 'STAFF CAR DRIVER II',
                'ASST. DIRECTOR (LAB)', 'STAFF CAR DRIVER III', 'DIRECTOR (MR)', 'SR. ATTENDANT',
                'DEPUTY DIRECTOR (MR)', 'ATTENDANT', 'MARKET RESEARCH OFFICER', 'STATISTICAL OFFICER'
            ],
            'J' => [ // Designation at present
                'QAO (LAB)', 'JQAO (LAB)', 'SECRETARY', 'FIELD OFFICER', 'SSA', 'ASST. SECRETARY',
                'QAO (EP&QA)', 'PUNCH OPERATOR', 'VIGILANCE OFFICER', 'JSA', 'CHIEF ACCOUNT OFFICER',
                'ACCOUNTANT', 'JR.INVESTIGATOR', 'ACCOUNTS OFFICER', 'SUPERINTENDENT', 'DIRECTOR (EP&QA)',
                'ASST. DIRECTOR (OL)', 'ASSISTANT', 'JT. DIRECTOR (EP&QA)', 'SR.TRANSLATOR', 'JR.TRANSLATOR',
                'DY. DIRECTOR (EP&QA)', 'SR.STENO', 'LIBRARIAN', 'ASST. DIRECTOR (EP&QA)', 'JR.STENO',
                'DIRECTOR (CDP)', 'UDC', 'DIRECTOR (TQM)', 'MAINTENANCE MECHANIC', 'DIRECTOR (LAB)', 'LDC',
                'JT. DIRECTOR (LAB)', 'STAFF CAR DRIVER I', 'DY. DIRECTOR (LAB)', 'STAFF CAR DRIVER II',
                'ASST. DIRECTOR (LAB)', 'STAFF CAR DRIVER III', 'DIRECTOR (MR)', 'SR. ATTENDANT',
                'DEPUTY DIRECTOR (MR)', 'ATTENDANT', 'MARKET RESEARCH OFFICER', 'STATISTICAL OFFICER'
            ],
            'K' => [ // Present posting
                'AHMEDABAD', 'AMRITSAR', 'BANGALORE', 'BELLARY', 'BHUBANESHWAR', 'CHANDIGARH',
                'CHENNAI', 'COCHIN', 'COCHIN2', 'COIMBATORE', 'DELHI - NCR', 'DEPUTATION',
                'GAUWHATI', 'GUNTUR', 'GURGOAN', 'HYDERABAD', 'ICHALKARANJI', 'INDORE',
                'JAIPUR', 'JODHPUR', 'KANNUR', 'KANPUR', 'KARUR', 'KOLKATA', 'LUDHIANA',
                'MADURAI', 'MUMBAI', 'MUMBAI - JNPT', 'NAGARI', 'NAGPUR', 'NEW DELHI',
                'NEW DELHI - EOK', 'NEW DELHI - NARAINA', 'PANIPAT', 'PONDICHERRY', 'SALEM',
                'SOLAPUR', 'SRINAGAR', 'SURAT', 'TIRUPUR', 'TUTICORINE', 'VARANSI'
            ],
            'R' => ['EXISTING', 'RETIRED', 'TRANSFERRED'], // Status
            'S' => ['Yes', 'No'], // Office in charge
            'T' => ['Yes', 'No'], // NPS
            'U' => ['Yes', 'No'], // Probation period
            'V' => ['Yes', 'No'], // Department
            'W' => ['Yes', 'No'], // Karmayogi certificate
            'AC' => ['Yes', 'No'], // Benevolent member
        ];

        // Apply dropdown validation to each column
        foreach ($dropdownOptions as $column => $options) {
            $this->applyDropdownValidation($sheet, $column, $options);
        }
    }

    private function applyDropdownValidation($sheet, $column, $options)
    {
        // Apply to first 100 rows
        $range = $column . '2:' . $column . '100';
        
        $validation = $sheet->getDataValidation($range);
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Invalid input');
        $validation->setError('Please select a value from the dropdown list.');
        $validation->setPromptTitle('Select from list');
        $validation->setPrompt('Please choose a value from the dropdown list.');
        
        // Set the formula with options (limited to avoid Excel issues)
        $validation->setFormula1('"' . implode(',', $options) . '"');
    }

    private function addValidationNotes($event)
    {
        // Add data validation notes
        $event->sheet->setCellValue('AG1', 'USAGE INSTRUCTIONS:');
        $event->sheet->setCellValue('AG2', '• Click on cells with dropdown arrows ↓');
        $event->sheet->setCellValue('AG3', '• Select from available options');
        $event->sheet->setCellValue('AG4', '• Do not type manually in dropdown fields');
        
        $event->sheet->setCellValue('AG6', 'DROPDOWN FIELDS:');
        $event->sheet->setCellValue('AG7', '• Gender (Column C)');
        $event->sheet->setCellValue('AG8', '• Category (Column D)');
        $event->sheet->setCellValue('AG9', '• Designation at Appointment (Column I)');
        $event->sheet->setCellValue('AG10', '• Designation at Present (Column J)');
        $event->sheet->setCellValue('AG11', '• Present Posting (Column K)');
        $event->sheet->setCellValue('AG12', '• Status (Column R)');
        $event->sheet->setCellValue('AG13', '• Yes/No Fields (Columns S-W, AC)');
        
        $event->sheet->setCellValue('AG15', 'FREE TEXT FIELDS:');
        $event->sheet->setCellValue('AG16', '• emp_code, name, education, mobile');
        $event->sheet->setCellValue('AG17', '• email, personal_file_no, home_town');
        $event->sheet->setCellValue('AG18', '• residential_address, pension_file_no');
        $event->sheet->setCellValue('AG19', '• seniority_sequence_no, etc.');

        $event->sheet->setCellValue('AI1', 'DATE FORMAT EXAMPLES:');
        $event->sheet->setCellValue('AI2', 'DD-MMM-YYYY:');
        $event->sheet->setCellValue('AI3', '15-Jan-2020');
        $event->sheet->setCellValue('AI4', 'DD/MM/YYYY:');
        $event->sheet->setCellValue('AI5', '15/01/2020');
        $event->sheet->setCellValue('AI6', 'MM/DD/YYYY:');
        $event->sheet->setCellValue('AI7', '01/15/2020');
        $event->sheet->setCellValue('AI8', 'YYYY-MM-DD:');
        $event->sheet->setCellValue('AI9', '2020-01-15');

        $event->sheet->setCellValue('AI11', 'INCREMENT MONTH:');
        $event->sheet->setCellValue('AI12', '• 1-12 (January-December)');
        $event->sheet->setCellValue('AI13', '• Or month names');

        $event->sheet->setCellValue('AI15', 'MOBILE NUMBER:');
        $event->sheet->setCellValue('AI16', '• 10 digits only');
        $event->sheet->setCellValue('AI17', '• No country code');

        // Style the notes section
        $notesRange = 'AG1:AK20';
        $event->sheet->getStyle($notesRange)->applyFromArray([
            'font' => [
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

        // Style headers in notes
        $headerCells = ['AG1', 'AG6', 'AG15', 'AI1', 'AI11', 'AI15'];
        foreach ($headerCells as $cell) {
            $event->sheet->getStyle($cell)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => '2E86C1'],
                ],
            ]);
        }

        // Auto-size the notes columns
        $event->sheet->getDelegate()->getColumnDimension('AG')->setWidth(25);
        $event->sheet->getDelegate()->getColumnDimension('AH')->setWidth(5);
        $event->sheet->getDelegate()->getColumnDimension('AI')->setWidth(20);
        $event->sheet->getDelegate()->getColumnDimension('AJ')->setWidth(5);
        $event->sheet->getDelegate()->getColumnDimension('AK')->setWidth(5);
    }
}