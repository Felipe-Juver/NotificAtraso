<?php
$funcionario = 'root'; // Usuário do banco de dados
$senha = '';           // Senha do banco de dados
$database = 'NotificAtraso'; // Nome do banco de dados
$host = 'localhost';    // Host do banco de dados

// Criar conexão com o banco de dados
$mysqli = new mysqli($host, $funcionario, $senha, $database);
$conn = new mysqli($host, $funcionario, $senha, $database);
if ($conn->connect_error) {
    die("Falha ao conectar com o banco de dados: " . $conn->connect_error);
}

// Verificar conexão
if ($mysqli->connect_error) {
    die("Falha ao conectar com o banco de dados: " . $mysqli->connect_error);
}
?>