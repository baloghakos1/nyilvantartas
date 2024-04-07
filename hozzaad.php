<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hozzaad</title>
</head>
<body>
<a href="muveletek.php"><button>Mégse</button></a>


<?php
require_once 'eszkozok.php';
$servername = "localhost";
$username = "root";
$password = null;
$database = "nyilvantartas";
$mysqli = new mysqli($servername, $username, $password, $database);
$x = Eszkozok::getLengths($mysqli);
echo '<form method="post">
<label for="input1">Név:</label><br>
<input type="text" id="input1" name="input1"><br>
<label for="input2">Raktár:</label><br>
<input type="number" min="1" max="'.$x[0].'" id="input2" name="input2"><br>
<label for="input3">Sor:</label><br>
<input type="number" min="1" max="'.$x[1].'" id="input3" name="input3"><br>
<label for="input4">Oszlop:</label><br>
<input type="number" min="1" max="'.$x[2].'" id="input4" name="input4"><br>
<label for="input5">Polc:</label><br>
<input type="number" min="1" max="'.$x[3].'" id="input5" name="input5"><br>
<label for="input6">Minimum Darabszám:</label><br>
<input type="number" id="input6" name="input6"><br>
<label for="input7">Darabszám:</label><br>
<input type="number" id="input7" name="input7"><br>
<label for="input8">Ár:</label><br>
<input type="number" id="input8" name="input8"><br>
<input type="submit" value="Mehet">
</form>';
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
    $adat = Eszkozok::getALL($mysqli);
    $szam = Eszkozok::getProductLength($mysqli);
    $letezik = Eszkozok::checkIfExist($adat,$szam,$b,$c,$d,$e);
}
if(isset($a)) {
    if($letezik) {
        $x = Eszkozok::getProductLength($mysqli);
        $id = $x[0][0]+1;
        Eszkozok::addData($mysqli,$id,$a,$b,$c,$d,$e,$f,$g,$h);
    }
    else {
        echo "Ezen a helyen már létezik termék";
    }
}
?>

</body>
</html>