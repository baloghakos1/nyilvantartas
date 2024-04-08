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
    <br>
    <form action="" method="post">
        <input type="text" id="inputField" name="inputField"><br>
        <button type="submit" name="submitButton">Keresés</button>
    </form>
    <br><br>
    <a href="hozzaad.php"><button>Adat hozzáadása</button></a>
    <a href="raktarmuveletek.php"><button>Raktár műveletek</button></a>
    <br>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = null;
    $database = "nyilvantartas";
    $mysqli = new mysqli($servername, $username, $password, $database);
    require_once "eszkozok.php";
    if(isset($_POST['btn-delete'])) {
        $id = $_POST['btn-delete'];
        Eszkozok::delete($mysqli, $id);
    }
    $all = Eszkozok::getALL($mysqli);
    if (isset($_POST['submitButton'])) {
        $inputValue = $_POST['inputField'];
        $search = Eszkozok::Search($mysqli, $inputValue);
        Eszkozok::showProducts($search);
    }
    else {
        Eszkozok::showProducts($all);
    }
    ?>
</body>
</html>