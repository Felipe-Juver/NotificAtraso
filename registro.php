<?php
require_once 'seguranca.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrar Atraso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      height: 100vh;
      display: flex;
      flex-direction: column;
      margin: 0;
    }

    header,
    footer {
      background-color: #343a40;
      color: white;
      padding: 15px 30px;
      min-height: 80px;
      font-size: 22px;
    }

    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
    }

    .NotificAtraso {
      font-size: 32px;
      font-weight: bold;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    header a,
    header span {
      color: white;
      text-decoration: none;
    }

    header a:hover {
      color: white;
      text-decoration: none;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #e9ecef;
    }

    .btn-yellow {
      background-color: #ffc107 !important;
      border-color: #ffc107 !important;
      font-weight: bold;
      transition: all 0.3s ease-in-out;
    }

    .btn-yellow:hover {
      background-color: #e0a800 !important;
      border-color: #e0a800 !important;
      transform: scale(1.02);
    }

    footer {
      text-align: center;
    }
  </style>
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

</head>

<body>

  <!-- NAVBAR -->
  <header>
    <a href="painel.php" class="d-flex align-items-center">
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

  <!-- FORMULÁRIO -->
  <main>
    <div class="container mt-4">
      <div class="card shadow">
        <div class="card-header bg-warning text-dark text-center">
          <h3 class="mb-0">Registrar Atraso</h3>
        </div>
        <div class="card-body">
          <form method="POST" action="registrar.php">
            <div class="mb-3">
              <label for="matricula" class="form-label">Matrícula:</label>
              <input type="text" class="form-control" id="matricula" name="matricula" required />
            </div>
            <div class="mb-3">
              <label for="nome_aluno" class="form-label">Nome do Aluno:</label>
              <input type="text" class="form-control" id="nome_aluno" name="nome_aluno" disabled />
            </div>
            <div class="mb-3">
              <label for="data" class="form-label">Data:</label>
              <input type="date" class="form-control" id="data" name="data" required />
            </div>
            <div class="mb-3">
              <label for="hora" class="form-label">Hora:</label>
              <input type="time" class="form-control" id="hora" name="hora" required />
            </div>
            <div class="mb-3">
              <label for="motivo" class="form-label">Motivo do Atraso:</label>
              <select class="form-select" id="motivo" name="motivo" required>
                <option value="">Selecione o motivo</option>
                <option value="Perdeu a hora">Perdeu a hora</option>
                <option value="Transporte">Transporte</option>
                <option value="Saúde">Saúde</option>
                <option value="Atendimento CAE">Atendimento CAE</option>
                <option value="Motivo Pessoal">Motivo Pessoal</option>
                <option value="Atendimento professor/coordenador">Atendimento professor/coordenador</option>
                <option value="Último período livre">Último período livre</option>
                <option value="Autorização dos responsáveis">Autorização dos responsáveis</option>
              </select>
            </div>

            <div class="mb-3 position-relative">
              <label for="nome_professor" class="form-label">Nome do Professor:</label>
              <input type="text" class="form-control" id="nome_professor" name="nome_professor" autocomplete="off"
                required />
              <div id="sugestoes_professor" class="list-group position-absolute w-100" style="z-index: 1000;"></div>
            </div>


            <button type="submit" class="btn btn-yellow w-100">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <!-- RODAPÉ -->
  <footer>
    &copy; 2024 Instituto Federal Farroupilha
  </footer>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function () {
      // Buscar nome do aluno via matrícula
      $('#matricula').on('blur', function () {
        var matricula = $(this).val();
        if (matricula !== '') {
          $.ajax({
            url: 'buscar_aluno.php',
            method: 'POST',
            data: { matricula: matricula },
            success: function (response) {
              $('#nome_aluno').val(response);
            },
            error: function () {
              alert('Erro ao buscar aluno.');
            }
          });
        }
      });

      // Buscar email do professor via nome
      $('#nome_professor').on('blur', function () {
        var nome = $(this).val();
        if (nome !== '') {
          $.ajax({
            url: 'buscar_professor.php',
            method: 'POST',
            data: { nome: nome },
            success: function (response) {
              $('#email_professor').val(response);
            },
            error: function () {
              alert('Erro ao buscar professor.');
            }
          });
        }
      });
    });
  </script>

  <script>
    $(document).ready(function () {
      $('#nome_professor').keyup(function () {
        var termo = $(this).val();
        if (termo.length >= 2) {
          $.ajax({
            url: 'autocomplete_professor.php',
            method: 'POST',
            data: { termo: termo },
            success: function (data) {
              var sugestoes = JSON.parse(data);
              var lista = '';
              sugestoes.forEach(function (item) {
                lista += '<button type="button" class="list-group-item list-group-item-action">' + item + '</button>';
              });
              $('#sugestoes_professor').html(lista).show();
            }
          });
        } else {
          $('#sugestoes_professor').hide();
        }
      });

      // Quando o usuário clica numa sugestão
      $(document).on('click', '#sugestoes_professor button', function () {
        $('#nome_professor').val($(this).text());
        $('#sugestoes_professor').hide();
      });

      // Oculta sugestões ao clicar fora
      $(document).click(function (e) {
        if (!$(e.target).closest('#nome_professor, #sugestoes_professor').length) {
          $('#sugestoes_professor').hide();
        }
      });
    });
  </script>

<script>
    // Impede navegação por histórico
    if (window.history && window.history.pushState) {
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.location.href = "index.php";
        };
    }
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>