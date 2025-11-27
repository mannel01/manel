<?php
    include_once(__DIR__ . "/../config.php");

    // Valida ID do game
    if (!isset($_GET['id'])) {
        header("Location: Game.php");
        exit;
    }

    $idgame = intval($_GET['id']);

    // Busca dados do game
    $sql = "SELECT * FROM game WHERE idgame = $idgame LIMIT 1";
    $result = $conexao->query($sql);

    if ($result->num_rows === 0) {
        header("Location: Game.php");
        exit;
    }

    $sqlDelete = "DELETE FROM game WHERE idgame=$idgame";
    $resultDelete = $conexao->query($sqlDelete);
    header("Location: Game.php");