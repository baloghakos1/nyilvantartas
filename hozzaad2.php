<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>valtoztat</title>
</head>
<body>
<a href="raktarmuveletek.php"><button>Mégse</button></a>



<?php
require_once 'eszkozok.php';
$servername = "localhost";
$username = "root";
$password = null;
$database = "nyilvantartas";
$mysqli = new mysqli($servername, $username, $password, $database);
$x = Eszkozok::getLengths($mysqli);
$asd = Eszkozok::getAllStores($mysqli);
echo '<form method="post">
<label for="input1">Név:</label><br>
<input type="text" id="input1" name="input1"><br>
<label for="input2">Cím:</label><br>
<input type="text" id="input2" name="input2"><br>
<input type="submit" value="Submit">
</form>';
if(isset($_POST['input1'])) {
    $a = $_POST['input1'];
    $b = $_POST['input2'];
}
if(isset($a)) {
    $id = $x[0]+1;
    Eszkozok::addRaktar($mysqli, $id, $a, $b);
}
?>

</body>
</html>