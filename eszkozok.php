<?php

class Eszkozok 
{

    static  function dbExists($mysqli,$db) {
        $sql = "SHOW DATABASES LIKE 'nyilvantartas';";

        return $mysqli->query($sql)->fetch_all();
    }

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

    static function showStore($name,$length,$tomb,$szamok,$min) {
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
            for($j=1;$j < $length[2]+1; $j++) {
                if($tomb[$i-1][$j-1][0] == "-") {
                    $result .= '<td>-</td>';
                }
                else {
                    $result .= '<td><b>'. $tomb[$i-1][$j-1][0] .'</b> <br>Darabszám:'.$szamok[$i-1][$j-1][0].' <br>Min darabszám:'.$min[$i-1][$j-1][0].'  </td>';
                }
                
            }
            $result .= '</tr>';
            for($j=1;$j < $length[3]; $j++) {
                $result .= '<tr>';
                for($k=1;$k < $length[2]+1; $k++) {
                    if($tomb[$i-1][$k-1][$j] == "-") {
                        $result .= '<td>-</td>';
                    }
                    else {
                        $result .= '<td><b>'.$tomb[$i-1][$k-1][$j] .'</b> <br>Darabszám:'.$szamok[$i-1][$k-1][$j].'<br>Min darabszám:'.$min[$i-1][$k-1][$j].' </td>';
                    }
                }
                $result .= '</tr>';
            }
            
        }
        
    $result .= '</Table>
        ';
        echo $result;
    }

    static function getStores($mysqli) {
        $a = "SELECT name FROM stores";
        return $mysqli->query($a)->fetch_all();
    }

    static function getALL($mysqli) {
        $a = "SELECT * FROM products";
        return $mysqli->query($a)->fetch_all();
    }

    static function getProductLength($mysqli) {
        $a = "SELECT COUNT(*) FROM products";
        return $mysqli->query($a)->fetch_all();
    }

    static function create3d($all, $length, $storeid, $numproducts) {
        $asd = array();
        for($i = 0; $i < $length[1]; $i++) {
            for($j = 0; $j < $length[2]; $j++) {
                for($k = 0; $k < $length[3]; $k++) {
                    $asd[$i][$j][$k] = "-";
                }
            }
        }
        for($i = 0; $i < $length[1]; $i++) {
            for($j = 0; $j < $length[2]; $j++) {
                for($k = 0; $k < $length[3]; $k++) {
                    for($l = 0; $l < $numproducts; $l++){
                        if($all[$l][4] == $i+1) {
                            if($all[$l][3] == $j+1) {
                                if($all[$l][2] == $k+1) {
                                    if($all[$l][5] == $storeid) {
                                        $asd[$i][$j][$k] = $all[$l][1];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $asd;
    }

    static function fill3d($length, $asd) {
        for($i = 0; $i < $length[1]; $i++) {
            for($j = 0; $j < $length[2]; $j++) {
                for($k = 0; $k < $length[3]; $k++) {
                    if($asd[$i][$j][$k] == null) {
                        $asd[$i][$j][$k] = "-";
                    }
                }
            }
        }
        return $asd;
    }

    static function createNumbers($all, $length, $storeid, $numproducts) {
        $asd = array();
        for($i = 0; $i < $length[1]; $i++) {
            for($j = 0; $j < $length[2]; $j++) {
                for($k = 0; $k < $length[3]; $k++) {
                    $asd[$i][$j][$k] = "-";
                }
            }
        }
        for($i = 0; $i < $length[1]; $i++) {
            for($j = 0; $j < $length[2]; $j++) {
                for($k = 0; $k < $length[3]; $k++) {
                    for($l = 0; $l < $numproducts; $l++){
                        if($all[$l][4] == $i+1) {
                            if($all[$l][3] == $j+1) {
                                if($all[$l][2] == $k+1) {
                                    if($all[$l][5] == $storeid) {
                                        $asd[$i][$j][$k] = $all[$l][7];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $asd;
    }

    static function createMinNumbers($all, $length, $storeid, $numproducts) {
        $asd = array();
        for($i = 0; $i < $length[1]; $i++) {
            for($j = 0; $j < $length[2]; $j++) {
                for($k = 0; $k < $length[3]; $k++) {
                    $asd[$i][$j][$k] = "-";
                }
            }
        }
        for($i = 0; $i < $length[1]; $i++) {
            for($j = 0; $j < $length[2]; $j++) {
                for($k = 0; $k < $length[3]; $k++) {
                    for($l = 0; $l < $numproducts; $l++){
                        if($all[$l][4] == $i+1) {
                            if($all[$l][3] == $j+1) {
                                if($all[$l][2] == $k+1) {
                                    if($all[$l][5] == $storeid) {
                                        $asd[$i][$j][$k] = $all[$l][6];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $asd;
    }

    static function fillMissing($nev, $szam, $min, $length, $store, $x, $result) {
        for($i = 0; $i < $length[1]; $i++) {
            for($j = 0; $j < $length[2]; $j++) {
                for($k = 0; $k < $length[3]; $k++) {
                    if($nev[$i][$j][$k] == "-") {
                        
                    }
                    else {
                        if($min[$i][$j][$k] > $szam[$i][$j][$k]) {
                            $result .= '<tr>';
                            $result .= '<td>'. $nev[$i][$j][$k] .'</td>
                            <td>'. $store[$x][0]. '</td>
                            <td>'.$i+1 .'. sor</td>
                            <td>'.$j+1 .'. oszlop</td>
                            <td>'.$k+1 .'. polc</td>
                            <td>'.$szam[$i][$j][$k] .' db</td>
                            <td>'.$min[$i][$j][$k] .' db</td>
                            ';
                        }
                    }
                }
            }
        }
        $result.= '</tr>';
        return $result;
    }
    
    static function showMissing($result) {
        $a = '
        <style>
        #szia {
            position: relative;
            top: 50px;
        }
        </style>
        <table id="szia">
        <tr>
            <th colspan=7>Kifogyóban lévő termékek</th>
        </tr>
        <tr>
          <th>Név</th>
          <th>Raktár</th>
          <th>Sor</th>
          <th>Oszlop</th>
          <th>Polc</th>
          <th>Db</th>
          <th>Min_db</th>
        </tr>
        ';
        $a .= $result;
        echo $a;
    }

    static function showProducts($adatok) {
        echo "
        <style>
        table, th, td {
        border:1px solid black;
        border-collapse: collapse;
        padding: 10px;
        margin-top: 20px;
        }
        </style>
        <table>
        <tr>
          <th>Név</th>
          <th>Raktár</th>
          <th>Sor</th>
          <th>Oszlop</th>
          <th>Polc</th>
          <th>Minimum Darabszám</th>
          <th>Darabszám</th>
          <th>Ár</th>
          <th>Gombok</th>
        </tr>
        ";
        for ($i = 0; $i < count($adatok); $i++) { 
            $a1 = $adatok[$i][1];
            $a2 = $adatok[$i][5];
            $a3 = $adatok[$i][4];
            $a4 = $adatok[$i][3];
            $a5 = $adatok[$i][2];
            $a6 = $adatok[$i][6];
            $a7 = $adatok[$i][7];
            $a8 = $adatok[$i][8];
            echo "
            <tr>
                <td>$a1</td>
                <td>$a2</td>
                <td>$a3</td>
                <td>$a4</td>
                <td>$a5</td>
                <td>$a6</td>
                <td>$a7</td>
                <td>$a8 Ft</td>
                <td>",
                    Eszkozok::showChangeButton($adatok[$i][0]);
                    Eszkozok::showDeleteButton($adatok[$i][0]);
                echo "</td>
                
            </tr>
            ";
        }
        echo "</table>";
    }

    static function showChangeButton($a) {
        echo '
            <form method="post" action="valtoztat.php?id=' . $a . '">
            <button id="btn-change" name="btn-change" title="change" value="'.$a.'">
            Adat módosítása
            </button>
            </form>
        ';
    }

    static function showDeleteButton($a) {
        echo '
        <form method="post" action="">
            <button id="btn-delete" name="btn-delete" title="delete" value="'.$a.'">
            Adat törlése
            </button>
        </form>
        ';
    }

    static function update($mysqli, $id,$a,$b,$c,$d,$e,$f,$g,$h)
    {
        $query = "UPDATE products SET name='$a', id_shelf='$e', id_column='$d', id_row='$c', id_store='$b', min_qty='$f', quantity='$g', price='$h' WHERE id = $id;";
        $mysqli->query($query);
    }

    static function delete($mysqli, $id)
    {
        $query = "DELETE FROM products WHERE id = $id";
        $mysqli->query($query);
    }

    static function addData($mysqli, $id,$a,$b,$c,$d,$e,$f,$g,$h)
    {
        $query = "INSERT INTO products (id, name, id_shelf, id_column, id_row, id_store, min_qty, quantity, price) VALUES ('$id', '$a', '$e', '$d', '$c', '$b', '$f', '$g', '$h')";
        $mysqli->query($query);
    }

    static function addRaktar($mysqli, $id ,$name, $address) {
        $query = "INSERT INTO stores (id, name, address) VALUES ('$id','$name', '$address')";
        $mysqli->query($query);
    }

    static function showStores($adatok) {
        echo "
        <style>
        table, th, td {
        border:1px solid black;
        border-collapse: collapse;
        padding: 10px;
        margin-top: 20px;
        }
        </style>
        <table>
        <tr>
          <th>Név</th>
          <th>Cím</th>
          <th>Gombok</th>
        </tr>
        ";
        for ($i = 0; $i < count($adatok); $i++) { 
            $a1 = $adatok[$i][1];
            $a2 = $adatok[$i][2];
            echo "
            <tr>
                <td>$a1</td>
                <td>$a2</td>
                <td>",
                    Eszkozok::showChangeButton2($adatok[$i][0]),
                    Eszkozok::showDeleteButton($adatok[$i][0]);
                echo "</td>
                
            </tr>
            ";
        }
    }

    static function getAllStores($mysqli) {
        $a = "SELECT * FROM stores";
        return $mysqli->query($a)->fetch_all();
    }

    static function delete2($mysqli, $id)
    {
        $query = "DELETE FROM stores WHERE id = $id";
        $mysqli->query($query);
    }

    static function showChangeButton2($a) {
        echo '
            <form method="post" action="valtoztat2.php?id=' . $a . '">
            <button id="btn-change" name="btn-change" title="change" value="'.$a.'">
            Adat módosítása
            </button>
            </form>
        ';
    }

    static function updateStores($mysqli, $id, $a, $b) {
        $query = "UPDATE stores SET name='$a', address='$b' WHERE id = $id;";
        $mysqli->query($query);
    }

    static function showAddButton2() {
        echo '
            <a href="hozzaad2.php"><button>Adat hozzáadása</button></a>
        ';
    }

    static function addRowButton() {
        echo '
        <form method="post" action="">
            <button id="addRow" name="addRow" title="addRow">
            Új sor hozzáadása
            </button>
        </form>
        ';
    }

    static function addRow($mysqli, $len) {
        $query = "INSERT INTO row (id, name) VALUES ('". $len+1 ."', '". $len+1 .". sor')";
        $mysqli->query($query);
    }

    static function deleteRowButton() {
        echo '
        <form method="post" action="">
            <button id="deleteRow" name="deleteRow" title="deleteRow">
            Sor törlése
            </button>
        </form>
        ';
    }

    static function deleteRow($mysqli, $len) {
        $query = "DELETE FROM row WHERE id = $len";
        $mysqli->query($query);
    }

    static function addColumnButton() {
        echo '
        <form method="post" action="">
            <button id="addColumn" name="addColumn" title="addColumn">
            Új oszlop hozzáadása
            </button>
        </form>
        ';
    }

    static function addColumn($mysqli, $len) {
        $query = "INSERT INTO column_ (id, name) VALUES ('". $len+1 ."', '". $len+1 .". oszlop')";
        $mysqli->query($query);
    }

    static function deleteColumnButton() {
        echo '
        <form method="post" action="">
            <button id="deleteColumn" name="deleteColumn" title="deleteColumn">
            Oszlop törlése
            </button>
        </form>
        ';
    }

    static function deleteColumn($mysqli, $len) {
        $query = "DELETE FROM column_ WHERE id = $len";
        $mysqli->query($query);
    }

    static function addShelfButton() {
        echo '
        <form method="post" action="">
            <button id="addShelf" name="addShelf" title="addShelf">
            Új polc hozzáadása
            </button>
        </form>
        ';
    }

    static function addShelf($mysqli, $len) {
        $query = "INSERT INTO shelves (id, name) VALUES ('". $len+1 ."', '". $len+1 .". polc')";
        $mysqli->query($query);
    }

    static function deleteShelfButton() {
        echo '
        <form method="post" action="">
            <button id="deleteShelf" name="deleteShelf" title="deleteShelf">
            Polc törlése
            </button>
        </form>
        ';
    }

    static function deleteShelf($mysqli, $len) {
        $query = "DELETE FROM shelves WHERE id = $len";
        $mysqli->query($query);
    }

    static function checkIfExist($all, $allLen, $b, $c, $d, $e) {
        for($i = 0; $i < $allLen[0][0]; $i++) {
            if ($all[$i][2] == $e) {
                if ($all[$i][3] == $d) {
                    if ($all[$i][4] == $c) {
                        if ($all[$i][5] == $b) {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    static function Search($mysqli, string $name)
    {
        $query = "SELECT * FROM products WHERE name LIKE '%$name%'";

        return $mysqli->query($query)->fetch_all();
    }

    static function showPdfButton() {
        echo '
        <form method="post" action="pdf/pdf.php">
            <button id="pdf" name="pdf" title="pdf">
            Kiírás pdf-be
            </button>
        </form>
        ';
    }

}