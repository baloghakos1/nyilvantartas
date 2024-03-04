<?php

class Eszkozok 
{
    static function showCreateDatabaseButton()
    {
        echo '
            <form method="post" action="adatbazis.php">
                <button id="btn-export" name="btn-export" title="Export to .CSV">
                    Adatbázis létrehozása/visszaállítása
                </button>
            </form>';
    }
    static function showBackButton()
    {
        echo '
            <form method="post" action="index.php">
                <button id="btn-export" name="btn-export" title="Export to .CSV">
                    Vissza
                </button>
            </form>';
    }

    static function getCsvData($file){
        $array = [];
        if(!file_exists($file)){
            echo "$file nem található";
            return false;
        }
        $csv = fopen($file, 'r');
        $line = fgetcsv($csv);
        while (!feof($csv)) {
            $line = fgetcsv($csv);
            $array[] = $line;
        }
        fclose($csv);
        return $array;
    }

    static function insertDataProduct($mysqli, $adatok, $truncate = false){
        if($truncate) {
            $mysqli->query("TRUNCATE TABLE products");
        }
        for($i = 0; $i < count($adatok); $i++) {
            $a1 = $adatok[$i][0];
            $a2 = $adatok[$i][1];
            $a3 = $adatok[$i][2];
            $a4 = $adatok[$i][3];
            $a5 = $adatok[$i][4];
            $mysqli->query("INSERT INTO products (id, name, id_column, min_qty, quantity, price) VALUES ('$i', '$a1', '$a2', '$a3', '$a4', '$a5')");
        }
    }
}