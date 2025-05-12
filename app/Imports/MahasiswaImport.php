<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // jika file punya header
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class MahasiswaImport implements ToCollection, WithCustomCsvSettings
{
    public $rows;

    public function collection(Collection $collection)
    {
        $this->rows = $collection;
    }
    
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
        ];
    }
}