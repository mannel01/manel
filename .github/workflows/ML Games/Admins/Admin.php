<?php
session_start();
include_once(__DIR__ . "/../config.php");

if (isset($_POST['cadastrar'])) {

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // impede cadastro vazio
    if (!empty($usuario) && !empty($senha)) {
        $sql = "INSERT INTO admin(usuario, senha) VALUES ('$usuario', '$senha')";
        $conexao->query($sql);
    }

    // redireciona para impedir duplicate POST
    header("Location: Admin.php");
    exit;
}

$sql = "SELECT * FROM admin ORDER BY idadmin DESC";
$result = $conexao->query($sql);
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML games</title>
    <link rel="stylesheet" href="Admin.css">
    
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
                <button type="submit" name="cadastrar" id="ButtonCadastrar">Cadastrar</button>
            </div>
        </form>

        <div class="vidro3">

            <div class="cad">
                <label class="ad">Admins</label>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Senha</th>
                        <th>Ação</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $user_data['idadmin'] . "</td>";
                        echo "<td>" . $user_data['usuario'] . "</td>";
                        echo "<td>" . $user_data['senha'] . "</td>";
                        echo "<td>
                            <a href='EditarAdmin.php?id=" . $user_data['idadmin'] . "'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                            </svg>
                            </a>
                            <a class='btn btn-sm btn-danger'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                                </svg>
                            </a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="Admin.js"></script>
</body>

</html>