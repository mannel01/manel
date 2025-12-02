<?php
session_start();
include_once(__DIR__ . "/../config.php");

$admin_id = $_SESSION['idadmin'] ?? null;

if (!$admin_id) {
    header("Location: ../Log/Login.php");
    exit;
}

/* =============================
   INSERIR COMPRA
================================ */

if (isset($_POST['cadastrar'])) {

    $cliente = $_POST['cliente'];
    $produto = $_POST['produto'];
    $datacompra = $_POST['datacompra'];
    $valortotal = $_POST['valortotal'];
    $nomecliente = $_POST['nomecliente'];
    $nomeproduto = $_POST['nomeproduto'];

    if (!empty($cliente) && !empty($produto) && !empty($datacompra) && !empty($valortotal)) {

        $sql = "INSERT INTO compra 
        (datacompra, valorcompra, cliente_idcliente, produto_idproduto, admin_idadmin, nome_cliente, nome_produto)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param(
            "sdiiiss",
            $datacompra,
            $valortotal,
            $cliente,
            $produto,
            $admin_id,
            $nomecliente,
            $nomeproduto
        );

        if (!$stmt->execute()) {
            die("ERRO AO INSERIR: " . $stmt->error);
        }
    }

    header("Location: Compra.php");
    exit;
}

/* =============================
   BUSCAR CLIENTES E JOGOS
================================ */

$sqlClientes = "SELECT idcliente, nome FROM cliente ORDER BY nome";
$clientes = $conexao->query($sqlClientes);

$sqlJogos = "SELECT idproduto, nome, preco FROM produto ORDER BY nome";
$jogos = $conexao->query($sqlJogos);

/* =============================
   BUSCAR COMPRAS
================================ */

$sqlCompras = "SELECT * FROM compra ORDER BY idcompra DESC";
$compras = $conexao->query($sqlCompras);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baratão do Tigas</title>
    <link rel="stylesheet" href="Compra.css">
</head>

<body>

    <div class="barra-tela-compra">
        <div class="logo"><img src="../Imgs/ML Games.png" alt=""></div>
        <a href="../Home/Home.php" class="btn-a">Voltar</a>
    </div>

    <form class="vidro" method="POST" action="Compra.php">

        <div>
            <label for="cliente">Selecione o cliente:</label>
            <select name="cliente" id="cliente" required>
                <option value="">Selecione...</option>

                <?php while ($c = $clientes->fetch_assoc()) { ?>
                    <option value="<?= $c['idcliente'] ?>"><?= $c['nome'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div>
            <label for="jogo">Selecione o produto:</label>
            <select name="produto" id="produto" required>
                <option value="">Selecione...</option>

                <?php while ($p = $produtos->fetch_assoc()) { ?>
                    <option value="<?= $p['idproduto'] ?>" data-preco="<?= $p['preco'] ?>"><?= $p['nome'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div>
            <label for="datacompra">Data da compra:</label>
            <input type="date" name="datacompra" id="datacompra" required>
        </div>

        <input type="hidden" name="valortotal" id="valortotal">
        <input type="hidden" name="nomecliente" id="nomecliente">
        <input type="hidden" name="nomeproduto" id="nomeproduto">

        <div class="btns">
            <button type="submit" name="cadastrar" id="ButtonCadastrar">Cadastrar</button>
        </div>

    </form>

    <div class="vidro3">
        <h2>Lista de Compras</h2>

        <table border="1" class="tabela-compras">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Data</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>

            <?php while ($compra = $compras->fetch_assoc()) { ?>
                <tr>
                    <td><?= $compra['idcompra'] ?></td>
                    <td><?= $compra['nome_cliente'] ?></td>
                    <td><?= $compra['nome_produto'] ?></td>
                    <td><?= $compra['datacompra'] ?></td>
                    <td>R$ <?= number_format($compra['valorcompra'], 2, ',', '.') ?></td>
                    <td>
                        <a href="EditarCompra.php?id=<?= $compra['idcompra'] ?>">
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325' />
                            </svg>
                        </a>
                        <a href="DeleteCompra.php?id=<?= $compra['idcompra'] ?>">
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0' />
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        document.getElementById("cliente").addEventListener("change", function() {
            document.getElementById("nomecliente").value =
                this.options[this.selectedIndex].text;
        });

        document.getElementById("produto").addEventListener("change", function() {
            let option = this.options[this.selectedIndex];
            document.getElementById("nomeproduto").value = option.text;
            document.getElementById("valortotal").value =
                option.getAttribute("data-preco");
        });
    </script>
</body>
</html>