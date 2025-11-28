<?php
    include_once(__DIR__ . "/../config.php");

    $id = intval($_GET['id']);

    $sql = "SELECT * FROM admin WHERE idadmin = $id";
    $result = $conexao->query($sql);

    if ($result->num_rows == 0) {
        header("Location: Admin.php");
        exit;
    }

    $sqlDelete = "DELETE FROM admin WHERE idadmin=$id";

    $conexao->query($sqlDelete);

    header("Location: Admin.php");
    exit;