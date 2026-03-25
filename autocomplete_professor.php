<?php
include 'conexao.php';

if (isset($_POST['termo'])) {
    $termo = $conn->real_escape_string($_POST['termo']);
    $sql = "SELECT nome FROM professores WHERE nome LIKE '%$termo%' LIMIT 5";
    $result = $conn->query($sql);

    $sugestoes = [];
    while ($row = $result->fetch_assoc()) {
        $sugestoes[] = $row['nome'];
    }

    echo json_encode($sugestoes);
}
?>