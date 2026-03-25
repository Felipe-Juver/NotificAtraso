<?php
require_once 'seguranca.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NotificAtraso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: hsl(48, 93%, 83%)
    }

    .navbar-custom,
    footer {
      background-color: #343a40;
      min-height: 70px;
    }

    .navbar-brand {
      color: white;
      font-weight: bold;
      font-size: 24px;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    .navbar-custom .nav-link,
    .navbar-custom span,
    .navbar-custom a {
      color: white;
      text-decoration: none;
    }

    .navbar-custom a:hover {
      color: white;
      text-decoration: none;
    }

    main {
      flex: 1;
      background-color: #f8f9fa;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 40px 20px;
    }

    .btn-option {
      width: 220px;
      height: 60px;
      font-size: 18px;
      font-weight: bold;
      background-color: #ffc107;
      border: none;
      color: #000;
      transition: all 0.3s ease-in-out;
    }

    .btn-option:hover {
      background-color: #e0a800;
      transform: scale(1.05);
    }

    footer {
      text-align: center;
      padding: 15px 0;
      color: white;
    }
  </style>
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-custom px-4 position-relative">
    <div class="container-fluid">
      <!-- Botão Logout à esquerda -->
      <a href="logout.php" class="nav-link d-flex align-items-center text-white me-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
          class="bi bi-box-arrow-right me-1" viewBox="0 0 16 16">
          <path fill-rule="evenodd"
            d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
          <path fill-rule="evenodd"
            d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
        </svg>
        Sair
      </a>

      <!-- Nome do sistema centralizado -->
      <span class="navbar-brand mx-auto">NotificAtraso</span>

      <!-- Nome do usuário à direita -->
      <span class="ms-auto d-flex align-items-center text-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
          class="bi bi-person-circle me-1" viewBox="0 0 16 16">
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
          <path fill-rule="evenodd"
            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
        </svg>
        <?php echo $_SESSION['nome']; ?>
      </span>
    </div>
  </nav>

  <!-- MAIN -->
  <main>
    <h1 class="mb-5 text-dark">Selecione a opção</h1>
    <div class="d-flex flex-column flex-md-row justify-content-center gap-4">
      <a href="registro.php"><button class="btn btn-option">Registrar atraso</button></a>
      <a href="editar_filtro.php"><button class="btn btn-option">Editar atraso</button></a>
      <a href="gerar_relatorio.php"><button class="btn btn-option">Consultar histórico</button></a>
    </div>
  </main>

  <!-- FOOTER -->
  <footer>
    &copy; 2024 Instituto Federal Farroupilha
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Impede navegação por histórico
    if (window.history && window.history.pushState) {
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.location.href = "index.php";
        };
    }
</script>



<script>
window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>

</body>

</html>