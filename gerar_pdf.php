<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $conn = new mysqli("localhost", "root", "", "NotificAtraso");
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Buscar dados do aluno
    $sqlAluno = "SELECT nome, matricula FROM alunos WHERE matricula = ?";
    $stmtAluno = $conn->prepare($sqlAluno);
    $stmtAluno->bind_param("s", $matricula);
    $stmtAluno->execute();
    $resultAluno = $stmtAluno->get_result();

    if ($resultAluno->num_rows > 0) {
        $aluno = $resultAluno->fetch_assoc();

        // Buscar atrasos com nome do professor
        $sqlAtrasos = "SELECT a.data_hora, a.motivo, p.nome AS professor 
                       FROM atrasos a
                       LEFT JOIN professores p ON a.professor_id = p.id_professor
                       WHERE a.matricula = ?";
        $stmtAtrasos = $conn->prepare($sqlAtrasos);
        $stmtAtrasos->bind_param("s", $matricula);
        $stmtAtrasos->execute();
        $resultAtrasos = $stmtAtrasos->get_result();

        $html = "
        <meta charset='UTF-8'>
        <h1 style='text-align:center;'>Relatório de Atrasos</h1>
        <p><strong>Nome:</strong> {$aluno['nome']}</p>
        <p><strong>Matrícula:</strong> {$aluno['matricula']}</p>
        <hr>
        <h3>Atrasos Registrados:</h3>";

        if ($resultAtrasos->num_rows > 0) {
            $html .= "<table border='1' cellspacing='0' cellpadding='6' width='100%'>
                        <thead>
                            <tr style='background-color:#f2f2f2;'>
                                <th>Data e Hora</th>
                                <th>Motivo</th>
                                <th>Professor</th>
                            </tr>
                        </thead>
                        <tbody>";
            while ($atraso = $resultAtrasos->fetch_assoc()) {
                $html .= "<tr>
                            <td>{$atraso['data_hora']}</td>
                            <td>{$atraso['motivo']}</td>
                            <td>{$atraso['professor']}</td>
                          </tr>";
            }
            $html .= "</tbody></table>";
        } else {
            $html .= "<p>Nenhum atraso registrado para este aluno.</p>";
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("relatorio_{$aluno['matricula']}.pdf", ["Attachment" => false]);

    } else {
        echo "<script>alert('Aluno não encontrado.');</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Matrícula não fornecida.');</script>";
}
