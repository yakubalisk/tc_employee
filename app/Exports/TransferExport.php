<?php

namespace App\Exports;

use App\Models\Transfer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransferExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;
    protected $region;
    protected $transferredRegion;
    protected $designation;

    public function __construct($search = null, $region = null, $transferredRegion = null, $designation = null)
    {
        $this->search = $search;
        $this->region = $region;
        $this->transferredRegion = $transferredRegion;
        $this->designation = $designation;
    }

    public function collection()
    {
        return Transfer::with(['designation', 'region', 'transferredRegion', 'departmentWorked'])
            ->search($this->search)
            ->filterByRegion($this->region)
            ->filterByTransferredRegion($this->transferredRegion)
            ->filterByDesignation($this->designation)
            ->orderBy('date_of_joining', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Transfer ID',
            'Employee ID',
            'Designation',
            'Date of Joining',
            'Date of Releiving',
            'Transfer Order No',
            'Transfer Remarks',
            'Region',
            'Date of Exit',
            'Duration',
            'Department Worked',
            'Transferred Region',
            'Created At',
            'Updated At'
        ];
    }

    public function map($record): array
    {
        return [
            $record->transferId,
            $record->empID,
            $record->designation->name ?? 'N/A',
            $record->date_of_joining->format('d-M-y'),
            $record->date_of_releiving->format('d-M-y'),
            $record->transfer_order_no,
            $record->transfer_remarks,
            $record->region->name ?? 'N/A',
            $record->date_of_exit ? $record->date_of_exit->format('d-M-y') : '',
            $record->duration,
            $record->departmentWorked->name ?? 'N/A',
            $record->transferredRegion->name ?? 'N/A',
            $record->created_at,
            $record->updated_at,
        ];
    }
}