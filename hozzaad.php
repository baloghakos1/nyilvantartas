<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>valtoztat</title>
</head>
<body>
<a href="muveletek.php"><button>Mégse</button></a>

<form method="post">
  <label for="input1">Név:</label><br>
  <input type="text" id="input1" name="input1"><br>
  <label for="input2">Raktár:</label><br>
  <input type="text" id="input2" name="input2"><br>
  <label for="input3">Sor:</label><br>
  <input type="text" id="input3" name="input3"><br>
  <label for="input4">Oszlop:</label><br>
  <input type="text" id="input4" name="input4"><br>
  <label for="input5">Polc:</label><br>
  <input type="text" id="input5" name="input5"><br>
  <label for="input6">Minimum Darabszám:</label><br>
  <input type="text" id="input6" name="input6"><br>
  <label for="input7">Darabszám:</label><br>
  <input type="text" id="input7" name="input7"><br>
  <label for="input8">Ár:</label><br>
  <input type="text" id="input8" name="input8"><br>
  <input type="submit" value="Submit">
</form>

<?php
require_once 'eszkozok.php';
$servername = "localhost";
$username = "root";
$password = null;
$database = "nyilvantartas";
$mysqli = new mysqli($servername, $username, $password, $database);
if(isset($_POST['input1'])) {
    $a = $_POST['input1'];
    $b = $_POST['input2'];
    $c = $_POST['input3'];
    $d = $_POST['input4'];
    $e = $_POST['input5'];
    $f = $_POST['input6'];
    $g = $_POST['input7'];
    $h = $_POST['input8'];
}
if(isset($a)) {
    $x = Eszkozok::getProductLength($mysqli);
    $id = $x[0][0]+1;
    Eszkozok::addData($mysqli,$id,$a,$b,$c,$d,$e,$f,$g,$h);
}
?>

</body>
</html>