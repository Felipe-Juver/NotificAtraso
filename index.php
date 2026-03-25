<?php
session_start();

/* BLOQUEIA CACHE (ESSENCIAL PARA VOLTAR / AVANÇAR) */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/* SE JÁ ESTIVER LOGADO, VAI DIRETO PARA O PAINEL */
if (isset($_SESSION['id_funcionario'])) {
    header("Location: painel.php");
    exit;
}

include('conexao.php');

/* PROCESSA LOGIN */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['cpf']) || empty($_POST['senha'])) {
        echo "<script>alert('Preencha CPF e senha');</script>";
    } else {

        $cpf   = $mysqli->real_escape_string($_POST['cpf']);
        $senha = $_POST['senha'];

        $stmt = $mysqli->prepare(
            "SELECT id_funcionario, nome, senha 
             FROM funcionarios 
             WHERE cpf = ?"
        );

        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {

            $funcionario = $result->fetch_assoc();

            if (password_verify($senha, $funcionario['senha'])) {

                session_regenerate_id(true);

                $_SESSION['id_funcionario'] = $funcionario['id_funcionario'];
                $_SESSION['nome'] = $funcionario['nome'];

                header("Location: painel.php");
                exit;

            } else {
                echo "<script>alert('Usuário ou senha incorretos');</script>";
            }

        } else {
            echo "<script>alert('Usuário ou senha incorretos');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotificAtraso - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: hsl(48, 93%, 83%);
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .bg-warning {
            background-color: #f6c300 !important;
        }

        h2,
        h3 {
            color: #fff;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .btn-warning {
            border-color: #f6c300;
            font-size: 1.1rem;
        }

        .btn-warning:hover {
            background-color: #e5b200;
            border-color: #e5b200;
        }

        a {
            color: #f6c300;
        }

        a:hover {
            color: #e5b200;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-5 shadow-lg w-100" style="max-width: 1100px;">
            <div class="row g-0">
                <!-- Coluna da logo -->
                <div class="col-md-5 d-flex flex-column align-items-center justify-content-center text-center">
                    <img src="imgs/NotificAtraso.png" alt="NotificAtraso" class="img-fluid mb-3"
                        style="max-width: 250px;">
                    <h2 class="fw-bold text-white">NotificAtraso</h2>
                </div>

                <!-- Coluna do formulário -->
                <div class="col-md-7 p-4">
                    <h3 class="mb-4 text-center fw-bold">Acessar o NotificAtraso</h3>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite seu CPF">
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha"
                                placeholder="Digite sua senha">
                        </div>
                        <button type="submit" class="btn btn-warning w-100 py-2">Login</button>

                    </form>
                    <p class="text-center text-muted mt-4">© 2024 Instituto Federal Farroupilha</p>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
/*
  Impede que o usuário avance para páginas protegidas
  após logout usando as setas do navegador
*/
window.history.pushState(null, null, window.location.href);

window.onpopstate = function () {
    window.history.pushState(null, null, window.location.href);
};
</script>

</body>

</html>