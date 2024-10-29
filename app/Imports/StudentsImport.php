<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Exception;

class StudentsImport implements ToModel, WithHeadingRow
{
    protected $className;

    public function __construct($className)
    {
        $this->className = $className;
    }

    public function model(array $row)
    {
        return new Student([
            'first_name'  => $row['first_name'],
            'last_name'   => $row['last_name'],
            'birth_date'  => $this->formatDate($row['birth_date']),
            'region'      => $row['region'],
            'sexe'        => $row['sexe'],
            'class_name'  => $this->className,
        ]);
    }

    /**
     * Format the date from Excel to YYYY-MM-DD.
     *
     * @param string $date
     * @return string|null
     */
    private function formatDate($date)
    {

        if (is_numeric($date)) {

            $baseDate = Carbon::createFromFormat('Y-m-d', '1900-01-01');
            $excelDate = $baseDate->addDays($date - 2);
            return $excelDate->format('Y-m-d');
        }
    }
}
