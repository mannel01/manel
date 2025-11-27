<?php
session_start();
include_once(__DIR__ . "/../config.php");

// Verifica admin logado
$admin_id = $_SESSION['idadmin'] ?? null;

if (!$admin_id) {
    header("Location: ../Log/Login.php");
    exit;
}

// -------------------- CADASTRAR GAME --------------------
if (isset($_POST['cadastrar'])) {
    
    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $preco = $_POST['preco'];
    
    // Insere o game atribuindo o admin logado
    $sql_insert = "INSERT INTO game (nome, genero, preco, admin_idadmin) 
                   VALUES ('$nome', '$genero', '$preco', $admin_id)";
    mysqli_query($conexao, $sql_insert);
    header("Location: ../Games/Game.php");
    exit;
}

// -------------------- LISTAR GAMES --------------------
$sql_select = "SELECT * FROM game ORDER BY idgame DESC";
$result = mysqli_query($conexao, $sql_select);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML Games</title>
    <link rel="stylesheet" href="Game.css">
</head>

<body>

    <div class="tela-produto">

        <img src="../Imgs/Jake.gif" alt="">

        <div class="barra-tela-produto"></div>

        <div class="logo"><img src="../Imgs/ML Games.png" alt=""></div>

        <a href="../Home/Home.php" class="btn-a">Voltar</a>

        <form class="vidro" method="POST" action="Game.php">

            <p>Nome</p>
            <input type="text" name="nome" required>

            <p>Gênero</p>
            <input type="text" name="genero" required>

            <p>Preço</p>
            <input type="text" name="preco" required>

            <div class="btns">
                <button type="submit" name="cadastrar">Cadastrar</button>
            </div>

        </form>

        <!-- <div class="vidro2"></div> -->
        <input type="search" name="pesquisar" placeholder="Pesquisar">
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>

        <div class="vidro3">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Gênero</th>
                        <th>Preço</th>
                        <th>ID Admin</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    while ($game = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $game['idgame'] . "</td>";
                        echo "<td>" . $game['nome'] . "</td>";
                        echo "<td>" . $game['genero'] . "</td>";
                        echo "<td>" . $game['preco'] . "</td>";
                        echo "<td>" . $game['admin_idadmin'] . "</td>";

                        echo "<td>
                                <a  href='EditarGame.php?id=" . $game['idgame'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                                    </svg>
                                </a>
                                <a href='DeleteGame.php?id=" . $game['idgame'] . "'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                                </svg>
                            </a>
                              </td>";

                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>

    </div>

    <script src="Game.js"></script>

</body>
</html>
