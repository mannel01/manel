<?php
    include_once(__DIR__ . "/../config.php");

    // Valida ID do game
    if (!isset($_GET['id'])) {
        header("Location: Produto.php");
        exit;
    }

    $idproduto = intval($_GET['id']);

    // Busca dados do produto
    $sql = "SELECT * FROM produto WHERE idproduto = $idproduto LIMIT 1";
    $result = $conexao->query($sql);

    if ($result->num_rows === 0) {
        header("Location: Produto.php");
        exit;
    }

    $sqlDelete = "DELETE FROM produto WHERE idproduto=$idproduto";
    $resultDelete = $conexao->query($sqlDelete);
    header("Location: Produto.php");