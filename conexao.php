<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "testesoftware";

$conexao = new mysqli($hostname, $username, $password, $dbname);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}
?>