<?php
if ((isset($_POST['acao']))) {
    include_once(__DIR__ . "/../config.php");

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $result = mysqli_query($conexao, "INSERT INTO admin(usuario, senha) 
    VALUES('$usuario','$senha')");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML games</title>
    <link rel="stylesheet" href="Admin.css">
    <link rel="stylesheet" href="../Global.css">
</head>

<body>

    <div class="barra-tela-admin">
        <div class="logo"><img src="../Imgs/ML Games.png" alt=""></div>
        <a href="../Log/Login.php">Voltar</a>
    </div>

    <div class="tela-admin">

        <form class="vidro" method="POST" action="Admin.php">
            <div>
                <label for="idusuario">Usuário</label>
                <input type="text" name="usuario" id="idusuario" required>
            </div>

            <div>
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>

            <div class="btns">
                <button type="submit" name="acao" value="cadastrar" id="ButtonCadastrar" disabled="true">
                    Cadastrar
                </button>
            </div>

        </form>

        <div class="vidro2"></div>

        <div class="cad">
            <label class="ad">Admins</label>
        </div>

        <div class="vidro3"></div>
    </div>

    <script src="Admin.js"></script>
</body>

</html>
