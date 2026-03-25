<?php
require_once 'seguranca.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Gerar Relatório de Atrasos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      padding-bottom: 70px;
    }

    .card {
      margin-top: 100px;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
      padding: 20px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    header,
    footer {
      background-color: #343a40;
      color: white;
      padding: 15px;
    }

    .NotificAtraso {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .btn-yellow {
      background-color: #ffc107 !important;
      border-color: #ffc107 !important;
      font-weight: bold;
      transition: all 0.3s ease-in-out;
    }

    footer {
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
   <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body>

  <header class="d-flex justify-content-between align-items-center">
    <a href="painel.php" class="text-white">
      <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-arrow-return-left"
        viewBox="0 0 16 16">
        <path fill-rule="evenodd"
          d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
      </svg>
    </a>
    <span class="NotificAtraso">NotificAtraso</span>
    <span>
      <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
        class="bi bi-person-circle me-2" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
        <path fill-rule="evenodd"
          d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
      </svg>
      <?php 
      echo $_SESSION['nome'] ?? ''; ?>
    </span>
  </header>

  <div class="card">
    <h4 class="mb-3 text-center">Gerar Relatório de Atrasos</h4>
    <form action="gerar_pdf.php" method="GET">
      <div class="mb-3">
        <label for="matricula" class="form-label">Digite a matrícula do aluno:</label>
        <input type="text" name="matricula" id="matricula" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-yellow w-100">Gerar Relatório em PDF</button>
    </form>
  </div>

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