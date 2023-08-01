<?php

// inclui o arquivo de conexão com o banco de dados
include('../src/conexao.php');

// Verifica se a conexão foi estabelecida com sucesso
if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

// inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["rm"])) {
    header("Location: ../view/login.php");
    exit();
}

// Verifica se o botão "Sair" foi clicado
if (isset($_GET["logout"]) && $_GET["logout"] == "true") {
    // Destruir todas as variáveis de sessão
    $_SESSION = array();

    // Destruir a sessão
    session_destroy();

    // Redirecionar para a página de login
    header("Location: ../view/login.php");
    exit();
}

// obtém o RM do usuário armazenado na sessão e o sanitiza
$rm = filter_var($_SESSION['rm'], FILTER_SANITIZE_NUMBER_INT);

// verifica se o RM é válido
if (!is_numeric($rm)) {
    die("Erro: RM inválido.");
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos foram preenchidos
    if (empty($_POST["senha_atual"]) || empty($_POST["nova_senha"]) || empty($_POST["confirmar_senha"])) {
        echo "<script>alert('Preencha todos os campos.');</script>";
        exit();
    }

    // Recebe os dados do formulário
    $senhaAtual = mysqli_real_escape_string($conn, $_POST["senha_atual"]);
    $novaSenha = mysqli_real_escape_string($conn, $_POST["nova_senha"]);
    $confirmarSenha = mysqli_real_escape_string($conn, $_POST["confirmar_senha"]);

    // Monta a consulta SQL para obter a senha atual do usuário
    $sql = "SELECT senha FROM usuarios WHERE rm = $rm";

    // Executa a consulta SQL
    $resultado = mysqli_query($conn, $sql);

    // Verifica se a consulta retornou um resultado
    if (mysqli_num_rows($resultado) == 1) {
        // Obtém a senha atual do usuário
        $linha = mysqli_fetch_assoc($resultado);
        $senhaCriptografada = $linha["senha"];

        // Verifica se a senha atual está correta
        if (password_verify($senhaAtual, $senhaCriptografada)) {
            // Verifica se a nova senha e a confirmação coincidem
            if ($novaSenha == $confirmarSenha) {
                // Criptografa a nova senha
                $novaSenhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);

                // Monta a consulta SQL para atualizar a senha do usuário
                $sql = "UPDATE usuarios SET senha = '$novaSenhaCriptografada' WHERE rm = $rm";

                // Executa a consulta SQL
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Senha alterada com sucesso.');</script>";
                    header("Location: perfil.php");
                } else {
                    echo "<script>alert('Erro ao alterar a senha.');</script>";
                }
            } else {
                echo "<script>alert('A nova senha e a confirmação não coincidem.');</script>";
            }
        } else {
            echo "<script>alert('Senha atual incorreta.');</script>";
        }
    } else {
        echo "<script>alert('Erro: usuário não encontrado.');</script>";
    }
}

// Encerra a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/perfil.css">
    <link rel="shortcut icon" href="assets/images/Logo-03.1.ico" type="image/x-icon">
    <title>Alterar Senha</title>
</head>
<body>
<header>
        <a href="https://etecfernandopolis.com.br/site/inicio/" target="_blank">
            <img class="logo-etec" src="../view/assets/images/logoEtec.svg" alt="Logo da ETEC de Fernandópolis">
        </a>
        <div class="header-links">
            <a href="estagios.php">Estágios</a>
            <a href="../index.php">Sobre</a>
            <a href="dicas.php">Dicas</a>
            <button><a href="perfil.php">PERFIL</a></button>
        </div>
    </header>
    <div class="container">
        <div class="form-image">
            <img src="assets/images/img-perfil.svg" alt="Imagem de Perfil">
        </div>
        <div class="form">
            <form action="alterar-senha.php" method="post">
                <div class="form-header">
                    <div class="title">
                        <h1>Alterar Senha</h1>
                    </div>
                    <div class="btn-voltar">
                        <button>
                            <a href="perfil.php" class="button">Voltar</a>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="senha_atual">Senha Atual:</label>
                    <input type="password" id="senha_atual" name="senha_atual" required>
                </div>
                <div class="form-group">
                    <label for="nova_senha">Nova Senha:</label>
                    <input type="password" id="nova_senha" name="nova_senha" required>
                </div>
                <div class="form-group">
                    <label for="confirmar_senha">Confirmar Senha:</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required>
                </div>
                <div class="btn-alterar">
                    <button type="submit">Alterar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
