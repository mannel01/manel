<?php
session_start();
include_once(__DIR__ . "/../config.php");

$filtro = $_POST['filtro'] ?? null;
$data_inicio = $_POST['data_inicio'] ?? null;
$data_fim = $_POST['data_fim'] ?? null;

$resultado_html = "";
$temRelatorio = false;

if ($filtro) {
    $temRelatorio = true;

    switch ($filtro) {

        /* =======================================================
           1 — TOTAL DE COMPRAS POR CLIENTE
        ======================================================== */
        case "total_cliente":
            $sql = "SELECT nome_cliente AS cliente, COUNT(*) AS total
                    FROM compra
                    GROUP BY nome_cliente
                    ORDER BY total DESC";
            $resultado = $conexao->query($sql);

            $resultado_html = "<h2>Total de compras por cliente</h2>";
            $resultado_html .= "<table border='1'><tr><th>Cliente</th><th>Total</th></tr>";

            while ($r = $resultado->fetch_assoc()) {
                $resultado_html .= "<tr>
                                        <td>{$r['cliente']}</td>
                                        <td>{$r['total']}</td>
                                    </tr>";
            }

            $resultado_html .= "</table>";
            break;

        /* =======================================================
           2 — TOTAL DE COMPRAS POR JOGO
        ======================================================== */
        case "total_jogo":
            $sql = "SELECT nome_jogo AS jogo, COUNT(*) AS total
                    FROM compra
                    GROUP BY nome_jogo
                    ORDER BY total DESC";
            $resultado = $conexao->query($sql);

            $resultado_html = "<h2>Total de compras por jogo</h2>";
            $resultado_html .= "<table border='1'><tr><th>Jogo</th><th>Total</th></tr>";

            while ($r = $resultado->fetch_assoc()) {
                $resultado_html .= "<tr>
                                        <td>{$r['jogo']}</td>
                                        <td>{$r['total']}</td>
                                    </tr>";
            }

            $resultado_html .= "</table>";
            break;

        /* =======================================================
           3 — VALOR TOTAL VENDIDO
        ======================================================== */
        case "valor_total":
            $sql = "SELECT SUM(valorcompra) AS total FROM compra";
            $resultado = $conexao->query($sql)->fetch_assoc();

            $total = number_format($resultado['total'], 2, ',', '.');

            $resultado_html = "<h2>Valor total vendido</h2>";
            $resultado_html .= "<p><strong>R$ $total</strong></p>";
            break;

        /* =======================================================
           4 — LISTAR TODAS AS COMPRAS POR CLIENTE
        ======================================================== */
        case "compras_cliente":
            $sql = "SELECT nome_cliente, nome_jogo, valorcompra, datacompra
                    FROM compra ORDER BY nome_cliente, datacompra DESC";

            $resultado = $conexao->query($sql);

            $resultado_html = "<h2>Compras por cliente</h2>";
            $resultado_html .= "<table border='1'>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Jogo</th>
                                    <th>Valor</th>
                                    <th>Data</th>
                                </tr>";

            while ($r = $resultado->fetch_assoc()) {
                $valor = number_format($r['valorcompra'], 2, ',', '.');

                $resultado_html .= "<tr>
                                        <td>{$r['nome_cliente']}</td>
                                        <td>{$r['nome_jogo']}</td>
                                        <td>R$ {$valor}</td>
                                        <td>{$r['datacompra']}</td>
                                    </tr>";
            }

            $resultado_html .= "</table>";
            break;

        /* =======================================================
           5 — LISTAR TODAS AS COMPRAS POR JOGO
        ======================================================== */
        case "compras_jogo":
            $sql = "SELECT nome_jogo, nome_cliente, valorcompra, datacompra
                    FROM compra ORDER BY nome_jogo, datacompra DESC";

            $resultado = $conexao->query($sql);

            $resultado_html = "<h2>Compras por jogo</h2>";
            $resultado_html .= "<table border='1'>
                                <tr>
                                    <th>Jogo</th>
                                    <th>Cliente</th>
                                    <th>Valor</th>
                                    <th>Data</th>
                                </tr>";

            while ($r = $resultado->fetch_assoc()) {
                $valor = number_format($r['valorcompra'], 2, ',', '.');

                $resultado_html .= "<tr>
                                        <td>{$r['nome_jogo']}</td>
                                        <td>{$r['nome_cliente']}</td>
                                        <td>R$ {$valor}</td>
                                        <td>{$r['datacompra']}</td>
                                    </tr>";
            }

            $resultado_html .= "</table>";
            break;

        /* =======================================================
           6 — MAIOR → MENOR
        ======================================================== */
        case "maior_compra":
            $sql = "SELECT * FROM compra ORDER BY valorcompra DESC";
            $resultado = $conexao->query($sql);

            $resultado_html = "<h2>Compras (maior → menor valor)</h2>";
            $resultado_html .= "<table border='1'>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Jogo</th>
                                    <th>Valor</th>
                                    <th>Data</th>
                                </tr>";

            while ($r = $resultado->fetch_assoc()) {
                $valor = number_format($r['valorcompra'], 2, ',', '.');

                $resultado_html .= "<tr>
                                        <td>{$r['nome_cliente']}</td>
                                        <td>{$r['nome_jogo']}</td>
                                        <td>R$ {$valor}</td>
                                        <td>{$r['datacompra']}</td>
                                    </tr>";
            }

            $resultado_html .= "</table>";
            break;

        /* =======================================================
           7 — MENOR → MAIOR
        ======================================================== */
        case "menor_compra":
            $sql = "SELECT * FROM compra ORDER BY valorcompra ASC";
            $resultado = $conexao->query($sql);

            $resultado_html = "<h2>Compras (menor → maior valor)</h2>";
            $resultado_html .= "<table border='1'>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Jogo</th>
                                    <th>Valor</th>
                                    <th>Data</th>
                                </tr>";

            while ($r = $resultado->fetch_assoc()) {
                $valor = number_format($r['valorcompra'], 2, ',', '.');

                $resultado_html .= "<tr>
                                        <td>{$r['nome_cliente']}</td>
                                        <td>{$r['nome_jogo']}</td>
                                        <td>R$ {$valor}</td>
                                        <td>{$r['datacompra']}</td>
                                    </tr>";
            }

            $resultado_html .= "</table>";
            break;

        /* =======================================================
           8 — FILTRAR COMPRAS POR PERÍODO
        ======================================================== */
        case "por_periodo":

            if (!$data_inicio || !$data_fim) {
                $resultado_html = "<h2>⚠ Selecione uma data inicial e final.</h2>";
                break;
            }

            $sql = "SELECT * FROM compra 
                    WHERE datacompra BETWEEN '$data_inicio' AND '$data_fim'
                    ORDER BY datacompra ASC";

            $resultado = $conexao->query($sql);

            $resultado_html = "<h2>Compras entre $data_inicio e $data_fim</h2>";
            $resultado_html .= "<table border='1'>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Jogo</th>
                                    <th>Valor</th>
                                    <th>Data</th>
                                </tr>";

            while ($r = $resultado->fetch_assoc()) {
                $valor = number_format($r['valorcompra'], 2, ',', '.');

                $resultado_html .= "<tr>
                                        <td>{$r['nome_cliente']}</td>
                                        <td>{$r['nome_jogo']}</td>
                                        <td>R$ {$valor}</td>
                                        <td>{$r['datacompra']}</td>
                                    </tr>";
            }

            $resultado_html .= "</table>";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML games</title>
    <link rel="stylesheet" href="Relatorio.css">
</head>
<body>
    
    <div class="barra-tela-relatorio">
        <div class="logo"><img src="../Imgs/ML Games.png" alt=""></div>
        <a href="../Home/Home.php" class="btn-a">Voltar</a>
    </div>

    <!-- FORMULÁRIO -->
    <form class="vidro" method="POST" action="Relatorio.php">

        <div class="camp">
            <label for="filtro">Selecione o filtro:</label>
            <select class="camp-s" name="filtro" id="filtro" required>
                <option value="">Selecione...</option>

                <option class="cam-s" value="total_cliente">Total de compras por cliente</option>
                <option value="total_jogo">Total de compras por jogo</option>
                <option value="valor_total">Valor total vendido</option>

                <option value="compras_cliente">Listar compras por cliente</option>
                <option value="compras_jogo">Listar compras por jogo</option>

                <option value="maior_compra">Maior → menor valor</option>
                <option value="menor_compra">Menor → maior valor</option>

                <option value="por_periodo">Compras por período</option>
            </select>
        </div>

        <!-- CAMPOS DE PERÍODO (APARECEM AUTOMATICAMENTE) -->
        <div id="periodo_campos" style="display:none; margin-top:10px;">

            <label>Data inicial:</label>
            <input type="date" name="data_inicio">

            <label>Data final:</label>
            <input type="date" name="data_fim">

        </div>

        <div class="btns">
            <button type="submit" name="gerar" id="gerar">Gerar relatório</button>
        </div>

    </form>

    <!-- RESULTADO -->
    <div class="vidro3">
        <?php
        if ($temRelatorio) {
            echo $resultado_html;
        }
        ?>
    </div>

    <script>
        // Exibir os campos de data quando o filtro "por período" for selecionado
        document.getElementById("filtro").addEventListener("change", function () {
            let periodo = document.getElementById("periodo_campos");

            if (this.value === "por_periodo") {
                periodo.style.display = "block";
            } else {
                periodo.style.display = "none";
            }
        });
    </script>

</body>
</html>
