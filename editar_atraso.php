<?php
require_once 'seguranca.php';
?>
<?php

include 'conexao.php';

$id = $_GET['id'] ?? '';

if (!$id) {
  die("ID do atraso não especificado.");
}

// Buscar os dados do atraso atual
$sql = "SELECT * FROM atrasos WHERE id_atraso = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  die("Atraso não encontrado.");
}

$atraso = $result->fetch_assoc();

// Atualizar dados se formulário enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nova_data_hora = $_POST['data_hora'];
  $novo_motivo = $_POST['motivo'];
  $novo_professor = $_POST['professor_id'];

  $sql_update = "UPDATE atrasos SET data_hora = ?, motivo = ?, professor_id = ? WHERE id_atraso = ?";
  $stmt_update = $conn->prepare($sql_update);
  $stmt_update->bind_param("ssii", $nova_data_hora, $novo_motivo, $novo_professor, $id);

  if ($stmt_update->execute()) {
    header("Location: listar_atrasos.php?matricula=" . $atraso['matricula']);
    exit;
  } else {
    $erro = "Erro ao atualizar: " . $conn->error;
  }
}

// Buscar professores para exibir no <select>
$professores = [];
$sql_prof = "SELECT id_professor, nome FROM professores";
$result_prof = $conn->query($sql_prof);
if ($result_prof) {
  while ($row = $result_prof->fetch_assoc()) {
    $professores[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Editar Atraso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    header {
      background-color: #343a40;
      color: white;
      padding: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header a {
      color: white;
      text-decoration: none;
    }

    .NotificAtraso {
      font-size: 1.5rem;
      font-weight: bold;
    }

    footer {
      background-color: #343a40;
      color: white;
      text-align: center;
      padding: 10px;
      position: fixed;
      bottom: 0;
      width: 100%;
    }

    body {
      padding-bottom: 70px;
    }

    .btn-yellow {
      background-color: #ffc107 !important;
      border-color: #ffc107 !important;
      font-weight: bold;
      transition: all 0.3s ease-in-out;
    }
  </style>
     <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body>

  <!-- NAVBAR -->
  <header>
    <a href="listar_atrasos.php?matricula=<?php echo $atraso['matricula']; ?>" class="d-flex align-items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-arrow-return-left"
        viewBox="0 0 16 16">
        <path fill-rule="evenodd"
          d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
      </svg>
    </a>
    <span class="NotificAtraso">NotificAtraso</span>
    <span class="d-flex align-items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
        class="bi bi-person-circle me-2" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
        <path fill-rule="evenodd"
          d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
      </svg>
      <?php echo $_SESSION['nome']; ?>
    </span>
  </header>

  <!-- CONTEÚDO -->
  <div class="container mt-5">
    <h3 class="mb-4">Editar Atraso</h3>

    <?php if (isset($erro)): ?>
      <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label for="data_hora" class="form-label">Data e Hora</label>
        <input type="datetime-local" class="form-control" id="data_hora" name="data_hora"
          value="<?php echo date('Y-m-d\TH:i', strtotime($atraso['data_hora'])); ?>" required>
      </div>

      <div class="mb-3">
  <label for="motivo" class="form-label">Motivo do Atraso</label>
  <select class="form-select" id="motivo" name="motivo" required>
    <option value="">Selecione o motivo</option>

    <?php
    $motivos = [
      "Perdeu a hora",
      "Transporte",
      "Saúde",
      "Atendimento CAE",
      "Motivo Pessoal",
      "Atendimento professor/coordenador",
      "Último período livre",
      "Autorização dos responsáveis"
    ];

    foreach ($motivos as $motivo) {
      $selected = ($atraso['motivo'] === $motivo) ? 'selected' : '';
      echo "<option value=\"$motivo\" $selected>$motivo</option>";
    }
    ?>
  </select>
</div>


      <div class="mb-3">
        <label for="professor_id" class="form-label">Professor Responsável</label>
        <select class="form-select" id="professor_id" name="professor_id" required>
          <option value="">Selecione</option>
          <?php foreach ($professores as $prof): ?>
            <option value="<?php echo $prof['id_professor']; ?>" <?php if ($prof['id_professor'] == $atraso['professor_id'])
                 echo 'selected'; ?>>
              <?php echo htmlspecialchars($prof['nome']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-yellow btn-success text-black">Salvar Alterações</button>
    </form>
  </div>

  <!-- RODAPÉ -->
  <footer>
    &copy; 2024 Instituto Federal Farroupilha
  </footer>
<script>
    // Impede navegação por histórico
    if (window.history && window.history.pushState) {
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.location.href = "index.php";
        };
    }
</script>
</body>

</html>