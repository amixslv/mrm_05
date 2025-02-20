<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class EnumService
{
    public function getEnumValues($table, $column)
    {
        $query = "SHOW COLUMNS FROM $table WHERE Field = '$column'";
        
        logger("Executing query: $query");

        $enumValues = DB::select($query);

        logger("Query result: ", $enumValues);

        if (empty($enumValues)) {
            return [];
        }

        $enum = str_replace("'", "", substr($enumValues[0]->Type, 5, -1));

        return explode(',', $enum);
    }

    //no izvēlētās tabulas parāda vienas kolonas sagrupētas vērtības ar iespēju filtrēt no citas kolonas
    public function getEnumFiltrValues($table, $column, $filterColumn = null, $filterValue = null)
{
    // Sākotnējais vaicājums
    $query = DB::table($table)
        ->select($column)
        ->distinct()
        ->where($filterColumn, $filterValue)
        ->groupBy($column)
        ->orderBy($column, 'asc');
        

    // Izpilda vaicājumu un iegūst unikālās vērtības
    $values = $query->get();

    return $values;
}

public function getEnumIDValues($table, $column, $filterColumn = null, $filterValue = null)
{
    // Sākotnējais vaicājums
    $query = DB::table($table)
        ->select('id',$column)
        ->distinct()
        ->where($filterColumn, $filterValue)
        ->orderBy($column, 'asc');
        

    // Izpilda vaicājumu un iegūst unikālās vērtības
    $values = $query->get();

    return $values;
}
    


}