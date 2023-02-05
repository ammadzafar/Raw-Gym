<?php

if (!function_exists('getPossibleEnumValues')) {
    function getPossibleEnumValues($table_name, $column)
    {
//    $instance = new static;
        $enumStr = DB::select(DB::raw('SHOW COLUMNS FROM ' . $table_name . ' WHERE Field = "' . $column . '"'))[0]->Type;
        preg_match_all("/'([^']+)'/", $enumStr, $matches);

        return isset($matches[1]) ? $matches[1] : [];
    }
}
