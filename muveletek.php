<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Műveletek</title>
</head>
<body>
    <a href="raktar.php"><button>Raktárak</button></a>
    <a href="index.php"><button>Főoldal</button></a>
    <h1>Műveletek</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = null;
    $database = "nyilvantartas";
    $mysqli = new mysqli($servername, $username, $password, $database);
    require_once "eszkozok.php";
    $all = Eszkozok::getALL($mysqli);
    Eszkozok::showProducts($all);
    ?>
</body>
</html>