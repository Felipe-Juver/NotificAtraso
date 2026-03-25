<?php
include("conexao.php");

if (isset($_POST['matricula'])) {
    $matricula = $_POST['matricula'];

    $query = "SELECT nome FROM alunos WHERE matricula = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $stmt->bind_result($nome);

    if ($stmt->fetch()) {
        echo $nome;
    } else {
        echo "Aluno não encontrado";
    }

    $stmt->close();
} else {
    echo "Parâmetro 'matricula' não enviado.";
}
?>