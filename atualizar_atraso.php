<?php
include('conexao.php');

$id = $_POST['id'];
$nome_aluno = $_POST['nome_aluno'];
$data = $_POST['data'];
$hora = $_POST['hora'];
$motivo = $_POST['motivo'];
$nome_professor = $_POST['nome_professor'];
$email_professor = $_POST['email_professor'];

$sql = "UPDATE atrasos SET 
        nome_aluno = ?, data = ?, hora = ?, motivo = ?, 
        nome_professor = ?, email_professor = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $nome_aluno, $data, $hora, $motivo, $nome_professor, $email_professor, $id);

if ($stmt->execute()) {
    echo "<div class='alert alert-success mt-3'>Atraso atualizado com sucesso!</div>";
    echo "<a href='editar_filtro.php' class='btn btn-primary mt-3'>Voltar</a>";
} else {
    echo "<div class='alert alert-danger mt-3'>Erro ao atualizar atraso.</div>";
}
?>