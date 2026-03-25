<?php
session_start();
include 'conexao.php';

/* BLOQUEIA CACHE */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/* VERIFICA LOGIN */
if (!isset($_SESSION['id_funcionario'])) {
    header("Location: index.php");
    exit;
}

/* VALIDA PARÂMETROS */
if (!isset($_GET['id']) || !isset($_GET['matricula'])) {
    echo "<script>
            alert('Parâmetros inválidos.');
            window.location.href = 'painel.php';
          </script>";
    exit;
}

$id = intval($_GET['id']);
$matricula = $_GET['matricula'];

/* EXCLUI ATRASO */
$sql = "DELETE FROM atrasos WHERE id_atraso = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>
            alert('Atraso excluído com sucesso!');
            window.location.href = 'listar_atrasos.php?matricula=$matricula';
          </script>";
} else {
    echo "<script>
            alert('Erro ao excluir atraso.');
            window.location.href = 'listar_atrasos.php?matricula=$matricula';
          </script>";
}
