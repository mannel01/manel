<?php
if ((isset($_POST['acao']))) {
    include_once(__DIR__ . "/../config.php");

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    $sql = "INSERT INTO cliente(nome,telefone,email, admin_idadmin) 
    VALUES('$nome', '$telefone', '$email', 3)";
    $result = mysqli_query($conexao, $sql);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML games</title>
    <link rel="stylesheet" href="Cliente.css">
    <link rel="stylesheet" href="../Global.css">
</head>

<body>

    <div class="barra-tela-cliente">
        <div class="logo"><img src="../Imgs/ML Games.png" alt=""></div>
        <a href="../Home/Home.php"><button type="button" class="btn-a" onclick="Home()">Voltar</button></a>
    </div>

    <div class="tela-cliente">

        <form class="vidro" method="POST" action="Cliente.php">

            <div>
                <label for="idnome">Nome</label>
                <input type="text" name="nome" id="idnome" placeholder="Nome" required>
            </div>

            <div>
                <label for="idtelefone">Telefone</label>
                <input type="text" name="telefone" id="idtelefone" placeholder="Telefone" required>
            </div>

            <div>
                <label for="idemail">E-mail</label>
                <input type="email" name="email" id="idemail" onchange="ValidarCampos()" placeholder="seu@email.com" required>
                <div class="error" id="email-obrigatorio">E-mail é obrigatório</div>
                <div class="error" id="email-invalido">E-mail inválido!</div>
            </div>

            <div class="btns">
                <button type="submit" name="acao" value="cadastrar" id="ButtonCadastrar">Cadastrar</button>
                <!-- <button type="submit" name="acao" value="atualizar" id="ButtonAtualizar" disabled="true">Atualizar</button>
                <button type="submit" name="acao" value="excluir" id="ButtonExcluir" disabled="true">Excluir</button> -->
            </div>
        </form>

        <label class="cl">Clientes</label>

        <div class="vidro2"></div>
        <div class="vidro3"></div>

    </div>

    <script src="Cliente.js"></script>

</body>

</html>