<?php
include("conexao.php");

if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];

    $query = "SELECT email FROM professores WHERE nome = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $stmt->bind_result($email);

    if ($stmt->fetch()) {
        echo $email;
    } else {
        echo "Professor não encontrado";
    }

    $stmt->close();
} else {
    echo "Parâmetro 'nome' não enviado.";
}
?>