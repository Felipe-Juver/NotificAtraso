<?php
session_start();

/* REMOVE TODAS AS VARIÁVEIS */
$_SESSION = [];

/* DESTROI A SESSÃO */
session_destroy();

/* APAGA O COOKIE DA SESSÃO */
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

/* EVITA CACHE */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

/* VOLTA PARA LOGIN */
header("Location: index.php");
exit;
