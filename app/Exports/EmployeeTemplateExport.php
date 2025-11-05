<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Designation; // Add this import

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
                'QAO (LAB)',                        // designation_at_appointment ID
                'JQAO (LAB)',                       // designation_at_present ID  
                '11',                       // present_posting ID
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
            'designation_at_appointment_id',
            'designation_at_present_id',
            'present_posting_id',
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

                // Auto-size columns
                $columns = [
                    'A' => 12, 'B' => 20, 'C' => 12, 'D' => 12, 'E' => 20, 'F' => 15,
                    'G' => 25, 'H' => 18, 'I' => 18, 'J' => 18, 'K' => 18, 'L' => 15,
                    'M' => 15, 'N' => 18, 'O' => 18, 'P' => 15, 'Q' => 25, 'R' => 12,
                    'S' => 15, 'T' => 10, 'U' => 15, 'V' => 12, 'W' => 25, 'X' => 18,
                    'Y' => 15, 'Z' => 15, 'AA' => 15, 'AB' => 20, 'AC' => 18, 'AD' => 18, 'AE' => 20
                ];
                
                foreach ($columns as $column => $width) {
                    $sheet->getColumnDimension($column)->setWidth($width);
                }

                // Style header row
                $headerRange = 'A1:AE1';
                $event->sheet->getStyle($headerRange)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 
                        'color' => ['rgb' => '2E86C1']
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

                // Style data rows
                $dataRange = 'A2:AE2';
                $event->sheet->getStyle($dataRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                // Add dropdown lists FIRST (before adding reference data)
                $this->addDropdownLists($sheet);

                // Add reference data
                $this->addReferenceData($event);

                // Add instructions
                $this->addInstructions($event);

                $sheet->freezePane('A2');
            },
        ];
    }

    private function addDropdownLists($sheet)
    {
    $designationNames = Designation::pluck('name')->toArray();
    
    // If list is too long, use cell references
    if (count($designationNames) > 20) {
        // Use cell reference method for long lists
        $startRow = 100;
        foreach ($designationNames as $index => $name) {
            $sheet->setCellValue('Z' . ($startRow + $index), $name);
        }
        $designationRange = 'Z' . $startRow . ':Z' . ($startRow + count($designationNames) - 1);
        
        $dropdownConfig = [
            'I' => [$designationRange, 'Designation Appointment'],
            'J' => [$designationRange, 'Designation Present'],
        ];
    } else {
        // Use direct formula for shorter lists
        $dropdownConfig = [
            'I' => [$designationNames, 'Designation Appointment'],
            'J' => [$designationNames, 'Designation Present'],
        ];
    }
        // Location IDs (1-42)  
        $locationIds = range(1, 42);
        $locationIdsFormatted = '"' . implode(',', $locationIds) . '"';


        // Apply dropdowns to specific columns
        $dropdownConfig += [
            // Column => [options, title]
            'C' => [['MALE', 'FEMALE', 'OTHER'], 'Gender'],
            'D' => [['General', 'OBC', 'SC', 'ST'], 'Category'],
            // 'I' => [['QAO (LAB)', 'JQAO (LAB)', 'QAO (EP&QA)', 'ST'], 'Designation Appointment ID'],
            // 'J' => [['QAO (LAB)', 'JQAO (LAB)', 'QAO (EP&QA)', 'ST'], 'Designation Present ID'], 
            // 'I' => [$hardcoded, 'Designation Hardcoded'],
            // 'I' => ['Z100:Z' . (100 + count($testDynamic) - 1), 'Designation Appointment'],
            // 'J' => ['Z100:Z' . (100 + count($testDynamic) - 1), 'Designation Present'],
            // 'J' => [$testDynamic, 'Designation Dynamic'],
            'K' => [$locationIds, 'Location ID'],
            'R' => [['EXISTING', 'RETIRED', 'TRANSFERRED'], 'Status'],
            'S' => [['Yes', 'No'], 'Office In Charge'],
            'T' => [['Yes', 'No'], 'NPS'],
            'U' => [['Yes', 'No'], 'Probation Period'],
            'V' => [['Yes', 'No'], 'Department'],
            'W' => [['Yes', 'No'], 'Karmayogi Certificate'],
            'AC' => [['Yes', 'No'], 'Benevolent Member'],
        ];

        foreach ($dropdownConfig as $column => [$options, $title]) {
            $this->applyDataValidation($sheet, $column, $options, $title);
        }
    // die();
    }

    private function setupNamedRanges($sheet, $designationNames, $locationNames)
{
    // Write designations to column Z starting from row 100
    $designationStart = 100;
    foreach ($designationNames as $index => $name) {
        $sheet->setCellValue('Z' . ($designationStart + $index), $name);
    }
    
    // Write locations to column AA starting from row 100
    $locationStart = 100;
    foreach ($locationNames as $index => $name) {
        $sheet->setCellValue('AA' . ($locationStart + $index), $name);
    }
    
    // Hide these columns if you want
    $sheet->getColumnDimension('Z')->setVisible(false);
    $sheet->getColumnDimension('AA')->setVisible(false);
}

    private function applyDataValidation($sheet, $column, $options, $title)
    {
        $range = $column . '2:' . $column . '1000'; // Apply to many rows
        
        $validation = $sheet->getDataValidation($range);
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Input error');
        $validation->setError("Value is not in list. Please select from dropdown.");
        $validation->setPromptTitle("Select $title");
        $validation->setPrompt("Please select a value from the dropdown list.");
        
        // // Convert options to comma-separated string
        // if (is_array($options)) {
        //     $formula = '"' . implode(',', $options) . '"';           
        //     $validation->setFormula1($formula);
        //     // echo "<pre>";
        //     // print_r($validation);
        //     // echo "</pre>";
        // }
            if (is_array($options)) {
        // For direct arrays (shorter lists)
        $formula = '"' . implode(',', $options) . '"';
        $validation->setFormula1($formula);
    } else {
        // For cell ranges (longer lists) - ADD THE = SIGN
        $validation->setFormula1('=' . $options);
    }
    }

    private function addReferenceData($event)
    {
        $sheet = $event->sheet->getDelegate();
        
        // Designation mapping
        $designations = [
            1 => 'QAO (LAB)', 2 => 'JQAO (LAB)', 3 => 'SECRETARY', 4 => 'FIELD OFFICER', 
            5 => 'SSA', 6 => 'ASST. SECRETARY', 7 => 'QAO (EP&QA)', 8 => 'PUNCH OPERATOR',
            9 => 'VIGILANCE OFFICER', 10 => 'JSA', 11 => 'CHIEF ACCOUNT OFFICER', 12 => 'ACCOUNTANT',
            13 => 'JR.INVESTIGATOR', 14 => 'ACCOUNTS OFFICER', 15 => 'SUPERINTENDENT', 16 => 'DIRECTOR (EP&QA)',
            17 => 'ASST. DIRECTOR (OL)', 18 => 'ASSISTANT', 19 => 'JT. DIRECTOR (EP&QA)', 20 => 'SR.TRANSLATOR',
            21 => 'JR.TRANSLATOR', 22 => 'DY. DIRECTOR (EP&QA)', 23 => 'SR.STENO', 24 => 'LIBRARIAN',
            25 => 'ASST. DIRECTOR (EP&QA)', 26 => 'JR.STENO', 27 => 'DIRECTOR (CDP)', 28 => 'UDC',
            29 => 'DIRECTOR (TQM)', 30 => 'MAINTENANCE MECHANIC', 31 => 'DIRECTOR (LAB)', 32 => 'LDC',
            33 => 'JT. DIRECTOR (LAB)', 34 => 'STAFF CAR DRIVER I', 35 => 'DY. DIRECTOR (LAB)', 36 => 'STAFF CAR DRIVER II',
            37 => 'ASST. DIRECTOR (LAB)', 38 => 'STAFF CAR DRIVER III', 39 => 'DIRECTOR (MR)', 40 => 'SR. ATTENDANT',
            41 => 'DEPUTY DIRECTOR (MR)', 42 => 'ATTENDANT', 43 => 'MARKET RESEARCH OFFICER', 44 => 'STATISTICAL OFFICER'
        ];

        // Location mapping
        $locations = [
            1 => 'AHMEDABAD', 2 => 'AMRITSAR', 3 => 'BANGALORE', 4 => 'BELLARY', 5 => 'BHUBANESHWAR',
            6 => 'CHANDIGARH', 7 => 'CHENNAI', 8 => 'COCHIN', 9 => 'COCHIN2', 10 => 'COIMBATORE',
            11 => 'DELHI - NCR', 12 => 'DEPUTATION', 13 => 'GAUWHATI', 14 => 'GUNTUR', 15 => 'GURGOAN',
            16 => 'HYDERABAD', 17 => 'ICHALKARANJI', 18 => 'INDORE', 19 => 'JAIPUR', 20 => 'JODHPUR',
            21 => 'KANNUR', 22 => 'KANPUR', 23 => 'KARUR', 24 => 'KOLKATA', 25 => 'LUDHIANA',
            26 => 'MADURAI', 27 => 'MUMBAI', 28 => 'MUMBAI - JNPT', 29 => 'NAGARI', 30 => 'NAGPUR',
            31 => 'NEW DELHI', 32 => 'NEW DELHI - EOK', 33 => 'NEW DELHI - NARAINA', 34 => 'PANIPAT',
            35 => 'PONDICHERRY', 36 => 'SALEM', 37 => 'SOLAPUR', 38 => 'SRINAGAR', 39 => 'SURAT',
            40 => 'TIRUPUR', 41 => 'TUTICORINE', 42 => 'VARANSI'
        ];

        // Add designation reference table
        $sheet->setCellValue('AG1', 'DESIGNATION REFERENCE');
        $sheet->setCellValue('AG2', 'ID');
        $sheet->setCellValue('AH2', 'DESIGNATION NAME');
        
        $row = 3;
        foreach ($designations as $id => $name) {
            $sheet->setCellValue('AG' . $row, $id);
            $sheet->setCellValue('AH' . $row, $name);
            $row++;
        }

        // Add location reference table
        $sheet->setCellValue('AJ1', 'LOCATION REFERENCE');
        $sheet->setCellValue('AJ2', 'ID');
        $sheet->setCellValue('AK2', 'LOCATION NAME');
        
        $row = 3;
        foreach ($locations as $id => $name) {
            $sheet->setCellValue('AJ' . $row, $id);
            $sheet->setCellValue('AK' . $row, $name);
            $row++;
        }

        // Style reference tables
        $refHeaderStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => '2E86C1']],
        ];
        
        $sheet->getStyle('AG1:AH1')->applyFromArray($refHeaderStyle);
        $sheet->getStyle('AJ1:AK1')->applyFromArray($refHeaderStyle);
        $sheet->getStyle('AG2:AH2')->applyFromArray($refHeaderStyle);
        $sheet->getStyle('AJ2:AK2')->applyFromArray($refHeaderStyle);
    }

    private function addInstructions($event)
    {
        $sheet = $event->sheet->getDelegate();

        $sheet->setCellValue('AM1', 'IMPORTANT INSTRUCTIONS:');
        $sheet->setCellValue('AM2', '1. Columns I, J, K have DROPDOWNS for IDs');
        $sheet->setCellValue('AM3', '2. Click on cells in these columns to see dropdown arrow ↓');
        $sheet->setCellValue('AM4', '3. Select ID from dropdown (refer to tables on left)');
        $sheet->setCellValue('AM5', '4. Store the ID in database for proper relationships');
        $sheet->setCellValue('AM6', '5. Other columns also have dropdowns for standardized data');

        // Style instructions
        $sheet->getStyle('AM1:AM6')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => 'FFF2CC']],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ]);

        // Auto-size instruction column
        $sheet->getColumnDimension('AM')->setWidth(35);
    }
}