<?php
if ((isset($_POST['acao']))) {
    include_once(__DIR__ . "/../config.php");

    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $preco = $_POST['preco'];

    $result = mysqli_query($conexao, "INSERT INTO game(nome, genero, preco, admin_idadmin) 
    VALUES('$nome', '$genero', '$preco', 3)");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML games</title>
    <link rel="stylesheet" href="Game.css">
</head>
<body>
    
    <div class="tela-produto">
        
        <img src="../Imgs/Jake.gif" alt="">
        
        <div class="barra-tela-produto"></div>

        <div class="logo"><img src="../Imgs/ML Games.png" alt=""></div>

        <a href="../Home/Home.php"><button class="btn-a">Voltar</button></a>

        <form class="vidro" method="POST" action="Game.php">

            <p>Nome</p>
            <input type="text" name="nome" required>

            <p>Gênero</p>
            <input type="text" name="genero" required>

            <p>Preço</p>
            <input type="text" name="preco" required>

            <div class="btns">
                <button type="submit" name="acao" value="cadastrar">Cadastrar</button>
                <!-- <button type="submit" name="acao" value="atualizar">Atualizar</button>
                <button type="submit" name="acao" value="excluir">Excluir</button> -->
            </div>

        </form>

        <div class="vidro2"></div>
        <div class="vidro3"></div>
    </div>
    
    <script src="Game.js"></script>
    
</body>
</html>
