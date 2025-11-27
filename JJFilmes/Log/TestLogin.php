<?php
session_start();

if (isset($_POST['acao']) && !empty($_POST['usuario']) && !empty($_POST['senha'])) {

    include_once(__DIR__ . "/../config.php");

    $usuario = $_POST['usuario'];
    $senha   = $_POST['senha'];

    $sql = "SELECT * FROM admin WHERE usuario = '$usuario' AND senha = '$senha'";
    $result = $conexao->query($sql);

    if ($result->num_rows == 1) {

        $admin = $result->fetch_assoc();

        // salva TODOS os dados importantes na sessão
        $_SESSION['idadmin'] = $admin['idadmin'];
        $_SESSION['usuario'] = $admin['usuario'];

        header("Location: ../Home/Home.php");
        exit;

    } else {
        // login falhou
        unset($_SESSION['usuario']);
        unset($_SESSION['senha']);
        header("Location: Login.php");
        exit;
    }

} else {
    header("Location: Login.php");
    exit;
}
