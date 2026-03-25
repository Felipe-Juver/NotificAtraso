<?php
require_once 'seguranca.php';
include 'conexao.php';

$matricula = $_GET['matricula'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Listar Atrasos</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- BLOQUEIO DE CACHE -->
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">

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

    .btn-yellow {
      background-color: #ffc107 !important;
      border-color: #ffc107 !important;
      font-weight: bold;
    }

    .btn-red {
      background-color: #dc3545 !important;
      border-color: #dc3545 !important;
      color: white !important;
      font-weight: bold;
    }

    body {
      padding-bottom: 60px;
    }
  </style>
</head>

<body>

<!-- NAVBAR -->
<header>
  <a href="editar_filtro.php" class="d-flex align-items-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
      class="bi bi-arrow-return-left" viewBox="0 0 16 16">
      <path fill-rule="evenodd"
        d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
    </svg>
  </a>

  <span class="NotificAtraso">NotificAtraso</span>

  <span class="d-flex align-items-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
      class="bi bi-person-circle me-2" viewBox="0 0 16 16">
      <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
      <path fill-rule="evenodd"
        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
    </svg>
    <?php echo htmlspecialchars($_SESSION['nome']); ?>
  </span>
</header>

<!-- CONTEÚDO -->
<div class="container mt-4">
  <h3 class="mb-4">
    Atrasos do aluno com matrícula <strong><?php echo htmlspecialchars($matricula); ?></strong>:
  </h3>

<?php
if ($matricula) {

  $sql = "SELECT a.id_atraso, a.data_hora, a.motivo, p.nome AS nome_professor
          FROM atrasos a
          LEFT JOIN professores p ON a.professor_id = p.id_professor
          WHERE a.matricula = ?";

  $stmt = $conn->prepare($sql);

  if ($stmt) {
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

      echo "<table class='table table-bordered table-striped'>";
      echo "<thead class='table-dark'>
              <tr>
                <th>Data e Hora</th>
                <th>Motivo</th>
                <th>Professor</th>
                <th>Ações</th>
              </tr>
            </thead><tbody>";

      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['data_hora']) . "</td>";
        echo "<td>" . htmlspecialchars($row['motivo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nome_professor']) . "</td>";
        echo "<td>
                <a class='btn btn-sm btn-yellow'
                   href='editar_atraso.php?id={$row['id_atraso']}'>Editar</a>

                <button class='btn btn-sm btn-red'
                        onclick='confirmarExclusao({$row['id_atraso']}, \"{$matricula}\")'>
                        Excluir
                </button>
              </td>";
        echo "</tr>";
      }

      echo "</tbody></table>";

    } else {
      echo "<div class='alert alert-info'>Nenhum atraso registrado para esta matrícula.</div>";
    }

  } else {
    echo "<div class='alert alert-danger'>Erro na consulta.</div>";
  }

} else {
  echo "<div class='alert alert-warning'>Matrícula não informada.</div>";
}
?>
</div>

<!-- RODAPÉ -->
<footer>
  &copy; 2024 Instituto Federal Farroupilha
</footer>

<!-- CONFIRMAÇÃO DE EXCLUSÃO -->
<script>
function confirmarExclusao(id, matricula) {
    if (confirm("Tem certeza que deseja excluir este atraso?")) {
        window.location.href = "excluir_atraso.php?id=" + id + "&matricula=" + matricula;
    }
}
</script>

</body>
</html>
