<?php
    include_once(__DIR__ . "/../config.php");

    if (!isset($_GET['id'])) {
        header("Location: Compra.php");
        exit;
    }

    $id = intval($_GET['id']);

    $sql = "SELECT * FROM compra WHERE idcompra = $id";
    $result = $conexao->query($sql);

    if ($result->num_rows == 0) {
        header("Location: Compra.php");
        exit;
    }

    $sqlDelete = "DELETE FROM compra WHERE idcompra=$id";

    $conexao->query($sqlDelete);

    header("Location: Compra.php");
    exit;