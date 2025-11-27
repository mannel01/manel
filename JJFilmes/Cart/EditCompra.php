<?php
session_start();
include_once(__DIR__ . "/../config.php");

$admin_id = $_SESSION['idadmin'] ?? null;

if (!$admin_id) {
    header("Location: ../Log/Login.php");
    exit;
}

/* ======================================================
   VERIFICA SE RECEBEU ID PARA EDITAR
====================================================== */
if (!isset($_GET['id'])) {
    die("ID da compra não informado.");
}

$idcompra = $_GET['id'];

/* ======================================================
   BUSCA DADOS DA COMPRA
====================================================== */

$sql = "SELECT * FROM compra WHERE idcompra = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idcompra);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Compra não encontrada.");
}

$compra = $result->fetch_assoc();

/* ======================================================
   BUSCAR CLIENTES E JOGOS
====================================================== */
$sqlClientes = "SELECT idcliente, nome FROM cliente ORDER BY nome";
$clientes = $conexao->query($sqlClientes);

$sqlJogos = "SELECT idgame, nome, preco FROM game ORDER BY nome";
$jogos = $conexao->query($sqlJogos);

/* ======================================================
   ATUALIZAR COMPRA
====================================================== */
if (isset($_POST['atualizar'])) {

    $cliente = $_POST['cliente'];
    $jogo = $_POST['jogo'];
    $data = $_POST['datacompra'];
    $valor = $_POST['valortotal'];
    $nomecliente = $_POST['nomecliente'];
    $nomejogo = $_POST['nomejogo'];

    $sqlUp = "UPDATE compra SET 
                datacompra = ?, 
                valorcompra = ?, 
                cliente_idcliente = ?, 
                game_idgame = ?, 
                nome_cliente = ?, 
                nome_jogo = ?
              WHERE idcompra = ?";

    $stmtUp = $conexao->prepare($sqlUp);
    $stmtUp->bind_param("sdisssi", $data, $valor, $cliente, $jogo, $nomecliente, $nomejogo, $idcompra);

    if (!$stmtUp->execute()) {
        die("Erro ao atualizar: " . $stmtUp->error);
    }

    header("Location: Compra.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Compra</title>
    <link rel="stylesheet" href="Compra.css">
</head>

<body>

    <div class="barra-tela-compra">
        <div class="logo"><img src="../Imgs/ML Games.png" alt=""></div>
        
    </div>

    <form class="vidro" method="POST">

        <!-- CLIENTE -->
        <label for="cliente">Cliente:</label>
        <select name="cliente" id="cliente" required>
            <?php while ($c = $clientes->fetch_assoc()) { ?>
                <option value="<?= $c['idcliente'] ?>"
                    <?= ($c['idcliente'] == $compra['cliente_idcliente']) ? "selected" : "" ?>>
                    <?= $c['nome'] ?>
                </option>
            <?php } ?>
        </select>

        <!-- JOGO -->
        <label for="jogo">Jogo:</label>
        <select name="jogo" id="jogo" required>
            <?php while ($j = $jogos->fetch_assoc()) { ?>
                <option value="<?= $j['idgame'] ?>"
                    data-preco="<?= $j['preco'] ?>"
                    <?= ($j['idgame'] == $compra['game_idgame']) ? "selected" : "" ?>>
                    <?= $j['nome'] ?>
                </option>
            <?php } ?>
        </select>

        <label for="datacompra">Data da compra:</label>
        <input type="date" name="datacompra" id="datacompra"
               value="<?= $compra['datacompra'] ?>" required>

        <!-- CAMPOS OCULTOS -->
        <input type="hidden" name="valortotal" id="valortotal" value="<?= $compra['valorcompra'] ?>">
        <input type="hidden" name="nomecliente" id="nomecliente" value="<?= $compra['nome_cliente'] ?>">
        <input type="hidden" name="nomejogo" id="nomejogo" value="<?= $compra['nome_jogo'] ?>">

        <div class="btns">
            <button type="submit" name="atualizar" class="btn-success">Salvar Alterações</button>
            <a href="Compra.php" class="btn-a">Cancelar</a>
        </div>

    </form>

    <!-- Script para preencher automaticamente -->
    <script>
        // Cliente → Preencher nome automaticamente
        document.getElementById("cliente").addEventListener("change", function () {
            document.getElementById("nomecliente").value =
                this.options[this.selectedIndex].text;
        });

        // Jogo → Preencher nome e preço automaticamente
        document.getElementById("jogo").addEventListener("change", function () {
            let op = this.options[this.selectedIndex];
            document.getElementById("nomejogo").value = op.text;
            document.getElementById("valortotal").value = op.getAttribute("data-preco");
        });
    </script>

</body>

</html>
