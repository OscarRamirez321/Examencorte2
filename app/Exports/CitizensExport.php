<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CitizensExport;

class CitizensExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Obtiene todos los ciudadanos con sus ciudades asociadas
        return Citizen::with('city')->get()->map(function($citizen) {
            return [
                'ID' => $citizen->id,
                'First Name' => $citizen->first_name,
                'Last Name' => $citizen->last_name,
                'Birth Date' => $citizen->birth_date,
                'City' => $citizen->city->name ?? 'N/A', // accede a los nombres de las ciudades por medio de las relaciones
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