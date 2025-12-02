<?php
session_start();
include_once(__DIR__ . "/../config.php");

// Verifica admin logado
$admin_id = $_SESSION['idadmin'] ?? null;

if (!$admin_id) {
    header("Location: ../Log/Login.php");
    exit;
}

// Valida ID do produto
if (!isset($_GET['id'])) {
    header("Location: Produto.php");
    exit;
}

$idproduto = intval($_GET['id']);

// Busca dados do produto
$sql = "SELECT * FROM produto WHERE idproduto = $idproduto LIMIT 1";
$result = mysqli_query($conexao, $sql);

if (mysqli_num_rows($result) === 0) {
    header("Location: Produto.php");
    exit;
}

$produto = mysqli_fetch_assoc($result);

// Atualizar produto
if (isset($_POST['editar'])) {

    $nome = $_POST['titulo'];
    $preco = $_POST['preco'];

    $update = "
        UPDATE produto 
        SET nome='$nome', preco='$preco', admin_idadmin=$admin_id
        WHERE idproduto=$idproduto
    ";

    mysqli_query($conexao, $update);

    header("Location: Produto.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="EditProduto.css">
</head>

<body>

    <div class="tela-produto">

        <img src="../Imgs/Jake.gif" alt="">

        <div class="barra-tela-produto"></div>

        <div class="logo">
            <img src="../Imgs/ML Games.png" alt="">
        </div>

        <form class="vidro" method="POST">

            <h2 class="titulo">Editar Produto</h2>

            <p>Título</p>
            <input type="text" name="nome" value="<?= $produto['nome'] ?>" required>

            <p>Preço</p>
            <input type="text" name="preco" value="<?= $produto['preco'] ?>" required>

            <div class="btns">
                <button type="submit" name="editar">Salvar Alterações</button>
                <a href="Produto.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>