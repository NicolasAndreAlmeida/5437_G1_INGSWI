<?php
//Conexion a la Base de datos
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'bd_bicicletasuio';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>

<?

?>
