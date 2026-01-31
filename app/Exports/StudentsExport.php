<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $students;

    public function __construct(Collection $students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students->map(function ($student) {
            return [
                'Name' => trim("{$student->first_name} {$student->middle_name} {$student->last_name}"),
                'Email' => $student->email,
                'Phone' => $student->mobile,
                'Status' => $student->status,
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
            'Status',
        ];
    }
}
