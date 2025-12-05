<?php
    include_once(__DIR__ . "/../config.php");

    if (!isset($_GET['id'])) {
        header("Location: Client.php");
        exit;
    }

    $id = intval($_GET['id']);

    $sql = "SELECT * FROM cliente WHERE idcliente = $id";
    $result = $conexao->query($sql);

    if ($result->num_rows == 0) {
        header("Location: Client.php");
        exit;
    }

    $sqlDelete = "DELETE FROM cliente WHERE idcliente=$id";

    $conexao->query($sqlDelete);

    header("Location: Client.php");
    exit;