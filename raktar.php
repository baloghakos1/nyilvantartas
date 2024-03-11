<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raktárak</title>
</head>
<body>
    <a href="index.php"><button>Főoldal</button></a>
    <h1>Raktárak</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = null;
    $database = "nyilvantartas";
    $mysqli = new mysqli($servername, $username, $password, $database);
    require_once "eszkozok.php";
    $szam = Eszkozok::getLengths($mysqli);
    Eszkozok::showStore("ASD",$szam);
    ?>
</body>
</html>