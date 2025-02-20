<?php

namespace App\Services;

use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class SelectionService
{
    //izveido departamentu no lietotāju datiem
    public function getDepartments()
{
    $departments = User::selectRaw(
        'TRIM(
            CONCAT_WS(" ", 
                NULLIF(country, "-"), 
                NULLIF(structure, "-"), 
                NULLIF(sub_structure, "-")
            )
        ) AS department'
    )
    ->distinct()
    ->get();

    return $departments;
}

    //  lai Veidojot departamenta aprakstu nerādītos departamenti kuriem jau ir izveidots apraksts
    public function getDepDep()
    {
        // Filtrējiet un apvienojiet kolonnas, ignorējot vērtības "-"
        $departments = User::selectRaw(
            'TRIM(
                CONCAT_WS(" ", 
                    NULLIF(country, "-"), 
                    NULLIF(structure, "-"), 
                    NULLIF(sub_structure, "-")
                )
            ) AS department'
        )
        ->distinct()
        ->get()
        ->pluck('department')
        ->toArray();
    
        $existingDepartments = Department::pluck('name')->toArray();
        $availableDepartments = array_diff($departments, $existingDepartments);
    
        return $availableDepartments;
    }
    

}
