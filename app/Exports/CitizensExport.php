<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel; // Add this line
use App\Exports\CitizensExport; // Add this line

class CitizensExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Eager load the 'city' relationship to avoid N+1 query issues
        return Citizen::with('city')->get()->map(function($citizen) {
            return [
                'ID' => $citizen->id,
                'First Name' => $citizen->first_name,
                'Last Name' => $citizen->last_name,
                'Birth Date' => $citizen->birth_date,
                'City' => $citizen->city->name ?? 'N/A', // Access city name via relationship
                'Address' => $citizen->address,
                'Phone' => $citizen->phone,
                'Created At' => $citizen->created_at,
                'Updated At' => $citizen->updated_at,
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Birth Date',
            'City',
            'Address',
            'Phone',
            'Created At',
            'Updated At',
        ];
    }
     public function exportXls()
    {
        return Excel::download(new CitizensExport, 'citizens.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new CitizensExport, 'citizens.csv');
    }
}