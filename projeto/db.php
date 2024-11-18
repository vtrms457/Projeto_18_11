<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();}

$host = "localhost";
$usuario = 'root';
$senha = "";     
$database = "projeto1"; 

$conn = new mysqli($host, $usuario, $senha, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);}

?>