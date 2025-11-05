<?php

namespace App\Helpers;

class EmployeeDataHelper
{
    const DESIGNATIONS = [
        1 => 'QAO (LAB)',
        2 => 'JQAO (LAB)',
        3 => 'SECRETARY',
        4 => 'FIELD OFFICER',
        5 => 'SSA',
        6 => 'ASST. SECRETARY',
        7 => 'QAO (EP&QA)',
        8 => 'PUNCH OPERATOR',
        9 => 'VIGILANCE OFFICER',
        10 => 'JSA',
        11 => 'CHIEF ACCOUNT OFFICER',
        12 => 'ACCOUNTANT',
        13 => 'JR.INVESTIGATOR',
        14 => 'ACCOUNTS OFFICER',
        15 => 'SUPERINTENDENT',
        16 => 'DIRECTOR (EP&QA)',
        17 => 'ASST. DIRECTOR (OL)',
        18 => 'ASSISTANT',
        19 => 'JT. DIRECTOR (EP&QA)',
        20 => 'SR.TRANSLATOR',
        21 => 'JR.TRANSLATOR',
        22 => 'DY. DIRECTOR (EP&QA)',
        23 => 'SR.STENO',
        24 => 'LIBRARIAN',
        25 => 'ASST. DIRECTOR (EP&QA)',
        26 => 'JR.STENO',
        27 => 'DIRECTOR (CDP)',
        28 => 'UDC',
        29 => 'DIRECTOR (TQM)',
        30 => 'MAINTENANCE MECHANIC',
        31 => 'DIRECTOR (LAB)',
        32 => 'LDC',
        33 => 'JT. DIRECTOR (LAB)',
        34 => 'STAFF CAR DRIVER I',
        35 => 'DY. DIRECTOR (LAB)',
        36 => 'STAFF CAR DRIVER II',
        37 => 'ASST. DIRECTOR (LAB)',
        38 => 'STAFF CAR DRIVER III',
        39 => 'DIRECTOR (MR)',
        40 => 'SR. ATTENDANT',
        41 => 'DEPUTY DIRECTOR (MR)',
        42 => 'ATTENDANT',
        43 => 'MARKET RESEARCH OFFICER',
        44 => 'STATISTICAL OFFICER'
    ];

    const LOCATIONS = [
        1 => 'AHMEDABAD',
        2 => 'AMRITSAR',
        3 => 'BANGALORE',
        4 => 'BELLARY',
        5 => 'BHUBANESHWAR',
        6 => 'CHANDIGARH',
        7 => 'CHENNAI',
        8 => 'COCHIN',
        9 => 'COCHIN2',
        10 => 'COIMBATORE',
        11 => 'DELHI - NCR',
        12 => 'DEPUTATION',
        13 => 'GAUWHATI',
        14 => 'GUNTUR',
        15 => 'GURGOAN',
        16 => 'HYDERABAD',
        17 => 'ICHALKARANJI',
        18 => 'INDORE',
        19 => 'JAIPUR',
        20 => 'JODHPUR',
        21 => 'KANNUR',
        22 => 'KANPUR',
        23 => 'KARUR',
        24 => 'KOLKATA',
        25 => 'LUDHIANA',
        26 => 'MADURAI',
        27 => 'MUMBAI',
        28 => 'MUMBAI - JNPT',
        29 => 'NAGARI',
        30 => 'NAGPUR',
        31 => 'NEW DELHI',
        32 => 'NEW DELHI - EOK',
        33 => 'NEW DELHI - NARAINA',
        34 => 'PANIPAT',
        35 => 'PONDICHERRY',
        36 => 'SALEM',
        37 => 'SOLAPUR',
        38 => 'SRINAGAR',
        39 => 'SURAT',
        40 => 'TIRUPUR',
        41 => 'TUTICORINE',
        42 => 'VARANSI'
    ];

    public static function getDesignations()
    {
        return self::DESIGNATIONS;
    }

    public static function getLocations()
    {
        return self::LOCATIONS;
    }

    public static function getDesignationName($id)
    {
        return self::DESIGNATIONS[$id] ?? null;
    }

    public static function getLocationName($id)
    {
        return self::LOCATIONS[$id] ?? null;
    }
}