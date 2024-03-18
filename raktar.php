<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raktárak</title>
</head>
<body>
    <a href="index.php"><button>Főoldal</button></a>
    <a href="muveletek.php"><button>Műveletek</button></a>
    <h1>Raktárak</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = null;
    $database = "nyilvantartas";
    $mysqli = new mysqli($servername, $username, $password, $database);
    require_once "eszkozok.php";
    $szam = Eszkozok::getLengths($mysqli);
    $store = Eszkozok::getStores($mysqli);
    $a = Eszkozok::getALL($mysqli);
    $x = Eszkozok::getProductLength($mysqli);
    $z = "";
    for($i = 0; $i < $szam[0]; $i++) {
        $b = Eszkozok::create3d($a,$szam,$i+1,$x[0][0]);
        $c = Eszkozok::fill3d($szam, $b);
        $d = Eszkozok::createNumbers($a,$szam,$i+1,$x[0][0]);
        $e = Eszkozok::fill3d($szam, $d);
        $f = Eszkozok::createMinNumbers($a,$szam,$i+1,$x[0][0]);
        $g = Eszkozok::fill3d($szam, $f);
        Eszkozok::showStore($store[$i][0],$szam,$c,$e,$g);
        $z = Eszkozok::fillMissing($c,$e,$g,$szam,$store,$i, $z);
        echo "<br>";
    }
    Eszkozok::showMissing($z);
    ?>
</body>
</html>