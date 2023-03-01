<?php

namespace App\Imports;

use App\Models\CarMake;
use App\Imports\MakeSheetImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CarMakesImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            'Acura Videos' => new MakeSheetImport(),
            'Buick Videos' => new MakeSheetImport(),
            'Cadillac Videos' => new MakeSheetImport(),
            'Chevrolet Videos' => new MakeSheetImport(),
            'Chrysler videos' => new MakeSheetImport(),
            'Dodge Videos' => new MakeSheetImport(),
            'Eagle Videos' => new MakeSheetImport(),
            'Ford Videos' => new MakeSheetImport(),
            'GMC Videos' => new MakeSheetImport(),
            'Geo Videos' => new MakeSheetImport(),
            'Honda Videos' => new MakeSheetImport(),
            'Infiniti Videos' => new MakeSheetImport(),
            'Hyundai Videos' => new MakeSheetImport(),
            'Isuzu Videos' => new MakeSheetImport(),
            'Jeep Videos' => new MakeSheetImport(),
            'Lincoln Videos' => new MakeSheetImport(),
            'Lexus Videos' => new MakeSheetImport(),
            'Mazda Videos' => new MakeSheetImport(),
            'Mercury Videos' => new MakeSheetImport(),
            'Mitsubishi Videos' => new MakeSheetImport(),
            'Nissan Videos' => new MakeSheetImport(),
            'Oldsmobile Videos' => new MakeSheetImport(),
            'Plymouth Videos' => new MakeSheetImport(),
            'Pontiac Videos' => new MakeSheetImport(),
            'Ram Videos' => new MakeSheetImport(),
            'Saturn Videos' => new MakeSheetImport(),
            'Scion Videos' => new MakeSheetImport(),
            'Subaru Videos' => new MakeSheetImport(),
            'Suzuki Videos' => new MakeSheetImport(),
            'Toyota Videos' => new MakeSheetImport(),
            'Volkswagen Videos' => new MakeSheetImport(),
            'Volvo Videos' => new MakeSheetImport()
        ];
    }
}
