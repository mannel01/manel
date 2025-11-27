<?php
    session_start();
    if (!isset($_SESSION['usuario']) == true and (!isset($_SESSION['senha']) == true)) {

        unset($_SESSION['usuario']);
        unset($_SESSION['senha']);
        header('Location: ../Log/Login.php');
    }
    $logado = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML games</title>
    <link rel="stylesheet" href="Home.css">
</head>

<body>
    <div class="tela-inicial">

        <div class="vidro">
            <a href="../Clients/Cliente.php" class="btn-a">Clientes</a>
            <a href="../Games/Game.php" class="btn-a">Games</a>
            <a href="../Cart/Compra.php" class="btn-a">Compras</a>
            <a href="../Reports/Relatorio.php" class="btn-a">Relatório</a>

        </div>


        <div class="vidro2">
            <img src="../Imgs/ML Games.png" alt="">
        </div>
        <div class="btn-av">
            <a href="Sair.php"><button class="btn-avo">Sair</button></a>
        </div>
    </div>


    </body> 
</html>