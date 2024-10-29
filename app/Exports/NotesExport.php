<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NotesExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // This function will return the array of data to be exported
    public function array(): array
    {
        return $this->data;
    }

    // This function will return the column headings
    public function headings(): array
    {
        return [
            'id',
            'First Name',
            'Last Name',
            'Class',
            'Semester',
            'Exam',
            'Note',
        ];
    }
}
