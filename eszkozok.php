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
        for($i = 1; $i < count($adatok)+1; $i++) {
            $a1 = $adatok[$i-1][0];
            $a2 = $adatok[$i-1][1];
            $a3 = $adatok[$i-1][2];
            $a4 = $adatok[$i-1][3];
            $a5 = $adatok[$i-1][4];
            $a6 = $adatok[$i-1][5];
            $a7 = $adatok[$i-1][6];
            $a8 = $adatok[$i-1][7];
            $mysqli->query("INSERT INTO products (id, name, id_shelf, id_column, id_row, id_store, min_qty, quantity, price) VALUES ('$i', '$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8')");
        }
    }

    static function insertDataName($mysqli, $adatok, $table ,$truncate = false){
        if($truncate) {
            $mysqli->query("TRUNCATE TABLE $table");
        }
        for($i = 1; $i < count($adatok)+1; $i++) {
            $a1 = $adatok[$i-1][0];
            $mysqli->query("INSERT INTO $table (id, name) VALUES ('$i', '$a1')");
        }
    }

    static function insertDataStore($mysqli, $adatok, $truncate = false){
        if($truncate) {
            $mysqli->query("TRUNCATE TABLE stores");
        }
        for($i = 1; $i < count($adatok)+1; $i++) {
            $a1 = $adatok[$i-1][0];
            $a2 = $adatok[$i-1][1];
            $mysqli->query("INSERT INTO stores (id, name, address) VALUES ('$i', '$a1', '$a2')");
        }
    }

    static function getProductsName($mysqli) {
        $a = "SELECT DISTINCT name FROM products";
        return $mysqli->query($a)->fetch_all();
    }
    static function showProductsDropdown(array $products) 
    {
        $result = '<form method="post">
            <select id="products-dropdown" name="products-dropdown">
            <option value = "" selected></option>';
        foreach ($products as $product) {
            if  ($product[0] == "") {
                
            }
            else {
                $result .= ('<option value =" ' . $product[0] . '">' . $product[0] . '</option>');
            }
            
        }
        $result .= '</select>
                    <button type="submit" name="submit">Mehet</button>
                    </form>';
        echo $result;
    }

    static function getProductPlace($mysqli, $product) {
        $product = ltrim($product, " ");
        $sql = 'SELECT products.name, shelves.name, column_.name, row.name, stores.name FROM `products`
        JOIN shelves ON products.id_shelf = shelves.id
        JOIN column_ ON products.id_column = column_.id
        JOIN row ON products.id_row = row.id
        JOIN stores ON products.id_store = stores.id
        WHERE products.name = "' . $product . '";';
        $a = $mysqli->query($sql)->fetch_all();
        return $a;
    }

    static function showProductPlace($place) {
        echo "
        <style>
        table, th, td {
        border:1px solid black;
        border-collapse: collapse;
        padding:5px;
        }
        </style>
        <table>
        <tr>
          <th>Név</th>
          <th>Raktár</th>
          <th>Sor</th>
          <th>Oszlop</th>
          <th>Polc</th>
        </tr>
        ";
        for ($i = 0; $i < count($place); $i++) { 
            $a1 = $place[$i][0];
            $a2 = $place[$i][1];
            $a3 = $place[$i][2];
            $a4 = $place[$i][3];
            $a5 = $place[$i][4];
            echo "
            <tr>
                <td><p>" . $a1 . "</p></td>
                <td><p>" . $a5 . "</p></td>
                <td><p>" . $a4 . "</p></td>
                <td><p>" . $a3 . "</p></td>
                <td><p>" . $a2 . "</p></td>
            </tr>
            ";
        }
        echo "</table>";
    }

    static function getLengths($mysqli) {
        $sql = "SELECT COUNT(*) FROM stores";
        $a = $mysqli->query($sql)->fetch_all();
        $a1 = $a[0][0];
        $sql = "SELECT COUNT(*) FROM row";
        $b = $mysqli->query($sql)->fetch_all();
        $b1 = $b[0][0];
        $sql = "SELECT COUNT(*) FROM column_";
        $c = $mysqli->query($sql)->fetch_all();
        $c1 = $c[0][0];
        $sql = "SELECT COUNT(*) FROM shelves";
        $d = $mysqli->query($sql)->fetch_all();
        $d1 = $d[0][0];
        $asd = [
            0 => $a1,
            1 => $b1,
            2 => $c1,
            3 => $d1
        ];
        return $asd;
    }

    static function showStore($name,$length) {
        $result = '
        <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 20px;
        }
        </style>
        <Table>
        <tr>
            <th>'.$name.'</th>';
            for($i = 1; $i < $length[2]+1; $i++) {
                $result .= '<th><h1>' . $i . '</h1></th>';
            }
        
        $result .= '</tr>';
        for($i = 1; $i < $length[1]+1; $i++ ) {
            $result .= '<tr>
            <th rowspan="'. $length[3] .'"><h1>' . $i . '</h1></th>';
            for($j=1;$j < $length[3]+1; $j++) {
                $result .= '<td></td>';
            }
            $result .= '</tr>';
            for($j=1;$j < $length[3]; $j++) {
                $result .= '<tr>';
                for($k=1;$k < $length[3]+1; $k++) {
                    $result .= '<td></td>';
                }
                $result .= '</tr>';
            }
        }
        
    $result .= '</Table>
        ';
        echo $result;
    }


}