

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML Games</title>
    <link rel="stylesheet" href="Login.css">
</head>

<body>

    <div class="login">
        
        <img src="../Imgs/Samurai.jpeg" alt="">

        <a href="../Admins/Admin.php"><button class="btn-a" type="button">Cadastrar</button></a>

        <form class="card" method="POST" action="testLogin.php">

            <div>
                <label>Usuário</label>
                <input class="campo" type="text" name="usuario" id="usuario" required>
            </div>

            <div>
                <label>Senha</label>
                <input class="campo" type="password" name="senha" id="senha" required>
                <input type="checkbox">
            </div>

            <button type="submit" name="acao" class="loginBotoes" id="ButtonEntrar">Entrar</button>
            
        </form>

    </div>

    

</body>

</html>
