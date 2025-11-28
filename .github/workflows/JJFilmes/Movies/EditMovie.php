<?php
session_start();
include_once(__DIR__ . "/../config.php");

// Verifica admin logado
$admin_id = $_SESSION['idadmin'] ?? null;

if (!$admin_id) {
    header("Location: ../Log/Login.php");
    exit;
}

// Valida ID do game
if (!isset($_GET['id'])) {
    header("Location: Movie.php");
    exit;
}

$idfilme = intval($_GET['id']);

// Busca dados do game
$sql = "SELECT * FROM filme WHERE idfilme = $idfilme LIMIT 1";
$result = mysqli_query($conexao, $sql);

if (mysqli_num_rows($result) === 0) {
    header("Location: Movie.php");
    exit;
}

$movie = mysqli_fetch_assoc($result);

// Atualizar game
if (isset($_POST['editar'])) {

    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $preco = $_POST['preco'];

    $update = "
        UPDATE filme 
        SET titulo='$titulo', genero='$genero', preco='$preco', admin_idadmin=$admin_id
        WHERE idfilme=$idfilme
    ";

    mysqli_query($conexao, $update);

    header("Location: Movie.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Filme</title>
    <link rel="stylesheet" href="EditMovie.css">
</head>

<body>

    <div class="tela-produto">

        <img src="../Imgs/Jake.gif" alt="">

        <div class="barra-tela-produto"></div>

        <div class="logo">
            <img src="../Imgs/ML Games.png" alt="">
        </div>

        <form class="vidro" method="POST">

            <h2 class="titulo">Editar Game</h2>

            <p>Título</p>
            <input type="text" name="titulo" value="<?= $movie['titulo'] ?>" required>

            <p>Gênero</p>
            <input type="text" name="genero" value="<?= $movie['genero'] ?>" required>

            <p>Preço</p>
            <input type="text" name="preco" value="<?= $movie['preco'] ?>" required>

            <div class="btns">
                <button type="submit" name="editar">Salvar Alterações</button>
                <a href="Movie.php" class="btn-cancelar">Cancelar</a>
            </div>

        </form>

    </div>

</body>
</html>