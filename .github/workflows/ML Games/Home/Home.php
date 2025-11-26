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
            <a href="../Clients/Cliente.php"><button class="btn-a">Clientes</button></a>
            <a href="../Games/Game.php"><button class="btn-a">Games</button></a>
            <button class="btn-a" onclick="Compras()">Compras</button>
            <button class="btn-a" onclick="Relatorio()">Relatório</button>

        </div>


        <div class="vidro2">
            <img src="../Imgs/ML Games.png" alt="">
        </div>
        <div class="btn-av">
            <a href="Sair.php"><button class="btn-avo">Sair</button></a>
        </div>
    </div>

    <script src="Home.js">
        < /scriptst> <
        /body> <
        /html>