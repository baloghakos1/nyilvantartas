<?php
require_once "eszkozok.php";
ini_set('memory_limit','-1');
$servername = "localhost";
$username = "root";
$password = null;
$mysqli = new mysqli($servername, $username, $password);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$sql = "CREATE DATABASE IF NOT EXISTS nyilvantartas";
if ($mysqli->query($sql) === TRUE) {
  echo "<p>Adatbázis sikeresen létrehozva\n</p>";
} else {
  echo "Error creating database: " . $mysqli->error;
}
$mysqli->close();
$database = "nyilvantartas";
$mysqli = new mysqli($servername, $username, $password, $database);
$sql = "CREATE TABLE IF NOT EXISTS stores (
    id int,
    name varchar(255),
    address varchar(255)
)";
if ($mysqli->query($sql) === TRUE) {
    echo "<p>Adattábla sikeresen létrehozva\n</p>";
} else {
    echo "Error creating Table: " . $mysqli->error;
}
$sql = "CREATE TABLE IF NOT EXISTS row (
    id int,
    name varchar(255),
    id_store int
)";
if ($mysqli->query($sql) === TRUE) {
    echo "<p>Adattábla sikeresen létrehozva\n</p>";
} else {
    echo "Error creating Table: " . $mysqli->error;
}
$sql = "CREATE TABLE IF NOT EXISTS 	column_ (
    id int,
    name varchar(255),
    id_row int
)";
if ($mysqli->query($sql) === TRUE) {
    echo "<p>Adattábla sikeresen létrehozva\n</p>";
} else {
    echo "Error creating Table: " . $mysqli->error;
}
$sql = "CREATE TABLE IF NOT EXISTS 	products (
    id int,
    name varchar(255),
    id_column int,
    min_qty int,
    quantity int,
    price int
)";
if ($mysqli->query($sql) === TRUE) {
    echo "<p>Adattábla sikeresen létrehozva\n</p>";
} else {
    echo "Error creating Table: " . $mysqli->error;
}

$file = "Products.csv";
$a = Eszkozok::getCsvData($file);
Eszkozok::insertDataProduct($mysqli, $a, true);
Eszkozok::showBackButton(); 
