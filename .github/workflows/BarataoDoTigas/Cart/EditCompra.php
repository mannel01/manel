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

$sqlProdutos = "SELECT idproduto, nome, preco FROM produto ORDER BY nome";
$sqlProdutos = $conexao->query($sqlProdutos);

/* ======================================================
   ATUALIZAR COMPRA
====================================================== */
if (isset($_POST['atualizar'])) {

    $cliente = $_POST['cliente'];
    $produto = $_POST['produto'];
    $data = $_POST['datacompra'];
    $valor = $_POST['valortotal'];
    $nomecliente = $_POST['nomecliente'];
    $nomeproduto = $_POST['nomeproduto'];

    $sqlUp = "UPDATE compra SET 
                datacompra = ?, 
                valorcompra = ?, 
                cliente_idcliente = ?, 
                produto_idproduto = ?, 
                nome_cliente = ?, 
                nome_produto = ?
              WHERE idcompra = ?";

    $stmtUp = $conexao->prepare($sqlUp);
    $stmtUp->bind_param("sdisssi", $data, $valor, $cliente, $produto, $nomecliente, $nomeproduto, $idcompra);

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


        <label for="cliente">Cliente:</label>
        <select name="cliente" id="cliente" required>
            <?php while ($c = $clientes->fetch_assoc()) { ?>
                <option value="<?= $c['idcliente'] ?>"
                    <?= ($c['idcliente'] == $compra['cliente_idcliente']) ? "selected" : "" ?>>
                    <?= $c['nome'] ?>
                </option>
            <?php } ?>
        </select>

        
        <label for="produto">Produto:</label>
        <select name="produto" id="produto" required>
            <?php while ($p = $produtos->fetch_assoc()) { ?>
                <option value="<?= $j['idproduto'] ?>"
                    data-preco="<?= $j['preco'] ?>"
                    <?= ($j['idproduto'] == $compra['produto_idproduto']) ? "selected" : "" ?>>
                    <?= $j['nome'] ?>
                </option>
            <?php } ?>
        </select>

        <label for="datacompra">Data da compra:</label>
        <input type="date" name="datacompra" id="datacompra"
               value="<?= $compra['datacompra'] ?>" required>


        <input type="hidden" name="valortotal" id="valortotal" value="<?= $compra['valorcompra'] ?>">
        <input type="hidden" name="nomecliente" id="nomecliente" value="<?= $compra['nome_cliente'] ?>">
        <input type="hidden" name="nomeproduto" id="nomeproduto" value="<?= $compra['nome_produto'] ?>">

        <div class="btns">
            <button type="submit" name="atualizar" class="btn-success">Salvar Alterações</button>
            <a href="Compra.php" class="btn-a">Cancelar</a>
        </div>

    </form>


    <script>
        
        document.getElementById("cliente").addEventListener("change", function () {
            document.getElementById("nomecliente").value =
                this.options[this.selectedIndex].text;
        });

        
        document.getElementById("produto").addEventListener("change", function () {
            let op = this.options[this.selectedIndex];
            document.getElementById("nomeproduto").value = op.text;
            document.getElementById("valortotal").value = op.getAttribute("data-preco");
        });
    </script>
</body>
</html>