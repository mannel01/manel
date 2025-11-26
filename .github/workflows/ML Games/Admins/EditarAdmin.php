<?php
include_once(__DIR__ . "/../config.php");

// Validação do ID
if (!isset($_GET['id'])) {
    header("Location: Admin.php");
    exit;
}

$id = $_GET['id'];

// Buscar dados do admin
$sql = "SELECT * FROM admin WHERE idadmin = $id";
$result = $conexao->query($sql);

if ($result->num_rows == 0) {
    header("Location: Admin.php");
    exit;
}

$admin = $result->fetch_assoc();

// Atualizar registro
if (isset($_POST['editar'])) {

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $update = "UPDATE admin SET usuario='$usuario', senha='$senha' WHERE idadmin=$id";
    $conexao->query($update);

    header("Location: Admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Admin</title>
    <link rel="stylesheet" href="EditarAdmin.css">
</head>

<body>

    <div class="barra-superior">
        <img src="../Imgs/ML Games.png" class="logo">
    </div>

    <div class="container">

        <form class="card" method="POST">
            <h2>Editar Admin</h2>

            <label for="usuario">Usuário</label>
            <input type="text" id="usuario" name="usuario" value="<?= $admin['usuario'] ?>" required>

            <label for="senha">Senha</label>
            <input type="text" id="senha" name="senha" value="<?= $admin['senha'] ?>" required>

            <button type="submit" name="editar" class="btn-editar">Salvar Alterações</button>
            <a href="Admin.php" class="btn-cancelar">Cancelar</a>
        </form>

    </div>

</body>
</html>
