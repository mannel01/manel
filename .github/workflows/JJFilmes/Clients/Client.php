<?php
session_start();
include_once(__DIR__ . "/../config.php");

$admin_id = $_SESSION['idadmin'] ?? null;

if (!$admin_id) {
    header("Location: ../Log/Login.php");
}

if (isset($_POST['cadastrar'])) {

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    if (!empty($nome) && !empty($telefone) && !empty($email)) {

        $sql = "INSERT INTO cliente (nome, telefone, email, admin_idadmin)
                VALUES (?, ?, ?, ?)";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssi", $nome, $telefone, $email, $admin_id);

        if (!$stmt->execute()) {
            die("ERRO AO INSERIR: " . $stmt->error);
        }
    }

    header("Location: Cliente.php");
    exit;
}

if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM cliente 
            WHERE nome LIKE '%$data%' 
            ORDER BY idcliente DESC";
} else {
    $sql = "SELECT * FROM cliente ORDER BY idcliente DESC";
}

$result = $conexao->query($sql);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML games</title>
    <link rel="stylesheet" href="Client.css">
</head>

<body>

    <div class="barra-tela-cliente">
        <div class="logo"><img src="../Imgs/ML Games.png" alt=""></div>
        <a href="../Home/Home.php"><button type="button" class="btn-a" onclick="Home()">Voltar</button></a>
    </div>

    <div class="tela-cliente">

        <form class="vidro" method="POST" action="Client.php">

            <div>
                <label for="idnome">Nome</label>
                <input type="text" name="nome" id="idnome" placeholder="Nome" required>
            </div>

            <div>
                <label for="idtelefone">Telefone</label>
                <input type="text" name="telefone" id="idtelefone" placeholder="Telefone" required>
            </div>

            <div>
                <label for="idemail">E-mail</label>
                <input type="email" name="email" id="idemail" onchange="ValidarCampos()" placeholder="seu@email.com" required>

            </div>

            <div class="btns">
                <button type="submit" name="cadastrar" value="cadastrar" id="ButtonCadastrar">Cadastrar</button>

            </div>
        </form>

        

        <!-- <div class="vidro2"></div> -->
        <div class="vidro4">
            <input type="search" name="pesquisar" id="p" placeholder="Pesquisar">
            <button onclick="searchData()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </button>
        </div>
        <div class="vidro3">
            <table class="table">

            <div class="cad">
                <label class="ad">Cliente</label>
            </div>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>ID Admin</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $user_data['idcliente'] . "</td>";
                        echo "<td>" . $user_data['nome'] . "</td>";
                        echo "<td>" . $user_data['telefone'] . "</td>";
                        echo "<td>" . $user_data['email'] . "</td>";
                        echo "<td>" . $user_data['admin_idadmin'] . "</td>";
                        echo "<td>
                            <a href='EditClient.php?id=" . $user_data['idcliente'] . "'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                                </svg>
                            </a>
                            <a  href='DeleteClient.php?id=" . $user_data['idcliente'] . "'>
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

    <script>
        var search = document.getElementById('pesquisar');

        search.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                searchData();
            }
        });

        function searchData() {
            window.location = 'Client.php?search=' + search.value;
        }
    </script>

</body>

</html>