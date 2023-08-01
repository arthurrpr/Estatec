<?php

include('../src/conexao.php');

session_start(); // Inicia a sessão

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se a conexão foi estabelecida com sucesso
    if (!$conn) {
        die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
    }

    // Verifica se os campos de RM e senha foram preenchidos
    if (empty($_POST["rm"]) || empty($_POST["senha"])) {
        echo "<script>alert('Preencha todos os campos');</script>";
        exit();
    }

    // Recebe os dados do formulário
    $rm = mysqli_real_escape_string($conn, $_POST["rm"]);
    $senha = mysqli_real_escape_string($conn, $_POST["senha"]);

    // Prepara a declaração
    $stmt = mysqli_prepare($conn, "SELECT * FROM usuarios WHERE rm=?");
    mysqli_stmt_bind_param($stmt, "s", $rm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Verifica se o usuário foi encontrado
    if (mysqli_num_rows($result) === 1) {
        // Obtém os dados do usuário
        $row = mysqli_fetch_assoc($result);
        $senhaCriptografada = $row['senha'];

        // Verifica se a senha está correta
        if (password_verify($senha, $senhaCriptografada)) {
            // Inicia a sessão e redireciona para a página correspondente
            session_start();
            $_SESSION["rm"] = $rm;
            if ($rm === "08670") {
                header("Location: ../index-adm.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            // Exibe uma mensagem de erro caso a senha esteja incorreta
            echo "<script>alert('RM ou senha incorretos. Tente novamente.');</script>";
        }
    } else {
        // Exibe uma mensagem de erro caso o usuário não tenha sido encontrado
        echo "<script>alert('RM ou senha incorretos. Tente novamente.');</script>";
    }

    // Encerra a conexão com o banco de dados
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="shortcut icon" href="assets/images/Logo-03.1.ico" type="image/x-icon">
    <title>Login ESTATEC</title>
</head>
<body>
    <main>
        <div class="container">
            <section>
                <h1>FAÇA LOGIN!</h1>
                <p>
                    ESTATEC é um site gerenciador de estágios, criado por
                    alunos da ETEC Fernandópolis, com o intuito de melhor
                    organização de oportunidades de trabalho de estágios
                    oferecidos pela instituição
                </p>
                <form method="POST">
                    <div class="input">
                        <div class="inputGroup">
                            <input type="text" required="" autocomplete="off">
                            <label for="name">RM</label>
                        </div>
                        <div class="inputGroup">
                            <input type="password" name="senha" required="" autocomplete="off">
                            <label for="name">Senha</label>
                        </div>
                        <input class="enviar" type="submit" value="ENVIAR">
                    </div>
                    <a class="cadastre-se" href="cadastrar.php">Não possui uma conta? Cadastre-se agora!</a>
                </form>
                <div class="linha"></div>
            </section>
            <img src="../view/assets/images/img-login.svg" alt="Imagem da Página de Login">
        </div>
    </main>
</body>
</html>
