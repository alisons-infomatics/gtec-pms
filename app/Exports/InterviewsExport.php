<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class InterviewsExport implements FromCollection, WithHeadings
{
    protected $interviews;

    public function __construct(Collection $interviews)
    {
        $this->interview = $interviews;
    }

    public function collection()
    {
        return $this->interview->map(function ($interview) {
            
            return [
                'Name' => trim("{$interview->GetStd->first_name} {$interview->GetStd->middle_name} {$interview->GetStd->last_name}"),
                'Email' => $interview->GetStd->email,
                'Phone' =>$interview->GetStd->mobile,
                'Attendance' =>$interview->attendance,
                'Status' => $interview->status,
                // Add more fields as needed
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Attendance',
            'Status',
        ];
    }
}
