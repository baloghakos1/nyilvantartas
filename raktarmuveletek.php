<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raktár műveletek</title>
</head>
<body>
    <a href="muveletek.php"><button>Mégse</button></a>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = null;
    $database = "nyilvantartas";
    $mysqli = new mysqli($servername, $username, $password, $database);
    require_once "eszkozok.php";
    if(isset($_POST['btn-delete'])) {
        $id = $_POST['btn-delete'];
        Eszkozok::delete2($mysqli, $id);
    }
    $len = Eszkozok::getLengths($mysqli);
    $all = Eszkozok::getAllStores($mysqli);
    Eszkozok::showStores($all);
    if(isset($_POST['addRow'])) {
        Eszkozok::addRow($mysqli, $len[1]);
    }
    if(isset($_POST['deleteRow'])) {
        Eszkozok::deleteRow($mysqli, $len[1]);
    }
    if(isset($_POST['addColumn'])) {
        Eszkozok::addColumn($mysqli, $len[2]);
    }
    if(isset($_POST['deleteColumn'])) {
        Eszkozok::deleteColumn($mysqli, $len[2]);
    }
    if(isset($_POST['addShelf'])) {
        Eszkozok::addShelf($mysqli, $len[3]);
    }
    if(isset($_POST['deleteShelf'])) {
        Eszkozok::deleteShelf($mysqli, $len[3]);
    }
    $len = Eszkozok::getLengths($mysqli);
    echo  "<h3>Sorok száma: $len[1]</h3>";
    echo  "<h3>Oszlopok száma: $len[2]</h3>";
    echo  "<h3>Polcok száma: $len[3]</h3>";
    Eszkozok::addRowButton();
    Eszkozok::deleteRowButton();
    echo "<br><br>";
    Eszkozok::addColumnButton();
    Eszkozok::deleteColumnButton();
    echo "<br><br>";
    Eszkozok::addShelfButton();
    Eszkozok::deleteShelfButton();
    echo "<br><br><br><br>";
    Eszkozok::showAddButton2();
    ?>
</body>
</html>