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
    
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $preco = $_POST['preco'];
    
    // Insere o game atribuindo o admin logado
    $sql_insert = "INSERT INTO filme (titulo, genero, preco, admin_idadmin) 
                   VALUES ('$titulo', '$genero', '$preco', $admin_id)";
    mysqli_query($conexao, $sql_insert);
    header("Location: ../Movie.php");
    exit;
}

// -------------------- LISTAR GAMES --------------------
$sql_select = "SELECT * FROM filme ORDER BY idfilme DESC";
$result = mysqli_query($conexao, $sql_select);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML Games</title>
    <link rel="stylesheet" href="Movie.css">
</head>

<body>

    <div class="tela-produto">

        <img src="../Imgs/Jake.gif" alt="">

        <div class="barra-tela-produto"></div>

        <div class="logo"><img src="../Imgs/ML Games.png" alt=""></div>

        <a href="../Home/Home.php" class="btn-a">Voltar</a>

        <form class="vidro" method="POST" action="Movie.php">

            <p>Título</p>
            <input type="text" name="titulo" required>

            <p>Gênero</p>
            <input type="text" name="genero" required>

            <p>Preço</p>
            <input type="text" name="preco" required>

            <div class="btns">
                <button type="submit" name="cadastrar">Cadastrar</button>
            </div>

        </form>

        <div class="vidro4">
            
            <input id="p" type="search" name="pesquisar" placeholder="Pesquisar">
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
        </button>
        </div>
        

        <div class="vidro3">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Gênero</th>
                        <th>Preço</th>
                        <th>ID Admin</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    while ($movie = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $movie['idtitulo'] . "</td>";
                        echo "<td>" . $movie['titulo'] . "</td>";
                        echo "<td>" . $movie['genero'] . "</td>";
                        echo "<td>" . $movie['preco'] . "</td>";
                        echo "<td>" . $movie['admin_idadmin'] . "</td>";

                        echo "<td>
                                <a  href='EditarMovie.php?id=" . $movie['idgame'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                                    </svg>
                                </a>
                                <a href='DeleteMovie.php?id=" . $movie['idgame'] . "'>
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

</body>
</html>
