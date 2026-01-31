<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class EmployerEnquiryExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($e) {
            return [
                'Company' => $e->company_name,
                'Email' => $e->email,
                'Status' => $e->status,
                'Follow-up Date' => optional($e->latest_enquiry)->follow_up_date,
                'Contact Person(s)' => $e->contacts->pluck('contact_person')->implode(', '),
                'Contact Number(s)' => $e->contacts->pluck('mobile')->implode(', ')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Company',
            'Email',
            'Status',
            'Follow-up Date',
            'Contact Person(s)',
            'Contact Number(s)'
        ];
    }
}
