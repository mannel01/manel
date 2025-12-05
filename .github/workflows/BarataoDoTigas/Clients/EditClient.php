<?php
session_start();
include_once(__DIR__ . "/../config.php");

// Verifica admin logado
$admin_id = $_SESSION['idadmin'] ?? null;

if (!$admin_id) {
    header("Location: ../Log/Login.php");
    exit;
}

// Verifica ID do cliente
if (!isset($_GET['id'])) {
    header("Location: Client.php");
    exit;
}

$id = intval($_GET['id']);

// Buscar cliente
$sql = "SELECT * FROM cliente WHERE idcliente = $id";
$result = $conexao->query($sql);

if ($result->num_rows == 0) {
    header("Location: Client.php");
    exit;
}

$cliente = $result->fetch_assoc();

// Atualizar cliente
if (isset($_POST['editar'])) {

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    // Agora inclui a foreign key do admin logado
    $update = "
        UPDATE cliente SET 
            nome = '$nome',
            telefone = '$telefone',
            email = '$email',
            admin_idadmin = $admin_id
        WHERE idcliente = $id
    ";

    $conexao->query($update);

    header("Location: Client.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="EditClient.css">
</head>

<body>

    <div class="barra-superior">
        <img src="../Imgs/ML Games.png" class="logo">
    </div>

    <div class="container">

        <form class="card" method="POST">
            <h2>Editar Cliente</h2>

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= $cliente['nome'] ?>" required>

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="<?= $cliente['telefone'] ?>" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= $cliente['email'] ?>" required>

            <button type="submit" name="editar" class="btn-editar">Salvar Alterações</button>
            <a href="Client.php" class="btn-cancelar">Cancelar</a>
        </form>

    </div>

</body>
</html>
