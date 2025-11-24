<?php
    session_start();
    if (isset($_POST['acao']) && !empty($_POST['usuario']) && !empty($_POST['senha'])) {

        include_once(__DIR__ . "/../config.php");
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];


        $sql = "SELECT * FROM admin WHERE usuario = '$usuario' AND senha = '$senha'";
        $result = $conexao->query($sql);


        if (mysqli_num_rows($result) < 1) {

            unset($_SESSION['usuario']);
            unset($_SESSION['senha']);
            header('Location: Login.php');
        } else {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['senha'] = $senha;
            header('Location: ../Home/Home.php');
        }
    } else {
        header('Location: Login.php');
    }
