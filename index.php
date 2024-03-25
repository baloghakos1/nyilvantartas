<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labdák nyilvántartása</title>
</head>
<body>
    <a href="raktar.php"><button>Raktárak</button></a>
    <a href="muveletek.php"><button>Műveletek</button></a>
    <h1>Labdák</h1>
    <?php
    require_once "eszkozok.php";
    $servername = "localhost";
    $username = "root";
    $password = null;
    //$database = "nyilvantartas";
    $mysqli = new mysqli($servername, $username, $password);
    $db = Eszkozok::dbExists($mysqli, "nyilvantartas");
    if($db == null) {
        Eszkozok::showCreateDatabaseButton();
    }
    else {
        $servername = "localhost";
        $username = "root";
        $password = null;
        $database = "nyilvantartas";
        $mysqli = new mysqli($servername, $username, $password, $database);
        $a = Eszkozok::getProductsName($mysqli);
        echo "<br>";
        echo "<h4>Válassz egy terméket: </h4>";
        Eszkozok::showProductsDropdown($a);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['products-dropdown'])) {
                $selected_option = $_POST['products-dropdown'];
                $x = Eszkozok::getProductPlace($mysqli, $selected_option);
                Eszkozok::showProductPlace($x);
            } else {
                echo "<p>Nincs kiválasztva semmi</p>";
            }
        }   
    }
    ?>
</body>
</html>