<?php
session_start();
include 'conexao.php';
/*
require_once 'enviar_email.php';
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // VERIFICA LOGIN
    if (!isset($_SESSION['id_funcionario'])) {
        die("Funcionário não está logado.");
    }

    $funcionario_id = $_SESSION['id_funcionario'];
    $matricula = $_POST['matricula'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $motivo = $_POST['motivo'];
    $nome_professor = $_POST['nome_professor'];



    // VERIFICA CONEXÃO
    if (!$conn) {
        die("Erro: Conexão com o banco de dados não foi estabelecida.");
    }

    /* =======================
       BUSCAR ALUNO
    ======================= */
    $stmtAluno = $conn->prepare(
        "SELECT nome, matricula, email_responsavel 
         FROM alunos 
         WHERE matricula = ?"
    );
    $stmtAluno->bind_param("s", $matricula);
    $stmtAluno->execute();
    $resultAluno = $stmtAluno->get_result();
    $aluno = $resultAluno->fetch_assoc();

    if (!$aluno) {
        echo "<script>alert('Aluno não encontrado.'); window.history.back();</script>";
        exit;
    }

    
// Buscar professor pelo nome
$stmtProfessor = $conn->prepare("SELECT id_professor, nome FROM professores WHERE nome = ?");
$stmtProfessor->bind_param("s", $nome_professor);
$stmtProfessor->execute();
$resultProfessor = $stmtProfessor->get_result();
$professor = $resultProfessor->fetch_assoc();

if (!$professor) {
    echo "<script>
            alert('Professor não encontrado.');
            window.history.back();
          </script>";
    exit;
}


    /* =======================
       INSERIR ATRASO
    ======================= */
    $dataHora = "$data $hora";

    $stmt = $conn->prepare(
        "INSERT INTO atrasos 
        (matricula, professor_id, funcionario_id, data_hora, motivo)
        VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "siiss",
        $matricula,
        $professor['id_professor'],
        $funcionario_id,
        $dataHora,
        $motivo
    );

    if ($stmt->execute()) {

        
        $dadosEmail = [
            'aluno'     => $aluno['nome'],
            'matricula' => $aluno['matricula'],
            'data_hora' => $dataHora,
            'motivo'    => $motivo,
            'professor' => $professor['nome']
        ];
        /*----------
        enviarEmailAtraso(
            $aluno['email_responsavel'],
            $dadosEmail
        );
  ------------------ */
        echo "<script>
                alert('Atraso registrado com sucesso!');
                window.location.href='painel.php';
              </script>";

    } else {
        echo "<script>
                alert('Erro ao registrar atraso: {$stmt->error}');
                window.history.back();
              </script>";
    }
              
}
?>
