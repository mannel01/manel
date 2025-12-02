<?php
    include_once(__DIR__ . "/../config.php");

    // Valida ID do game
    if (!isset($_GET['id'])) {
        header("Location: Movie.php");
        exit;
    }

    $idfilme = intval($_GET['id']);

    // Busca dados do game
    $sql = "SELECT * FROM filme WHERE idfilme = $idfilme LIMIT 1";
    $result = $conexao->query($sql);

    if ($result->num_rows === 0) {
        header("Location: Movie.php");
        exit;
    }

    $sqlDelete = "DELETE FROM filme WHERE idfilme=$idfilme";
    $resultDelete = $conexao->query($sqlDelete);
    header("Location: Movie.php");