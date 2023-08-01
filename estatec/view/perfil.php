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

// Monta a consulta SQL para recuperar o nome e email do usuário a partir do rm
$sql = "SELECT * FROM usuarios WHERE rm = $rm";

// Executa a consulta SQL
$resultado = mysqli_query($conn, $sql);

// Verifica se a consulta retornou resultados
if (mysqli_num_rows($resultado) > 0) {
    // Obtém o array associativo com os resultados da consulta
    $linha = mysqli_fetch_assoc($resultado);

    // Armazena o nome e email do usuário em variáveis
    $nome = $linha['nome'];
    $sobrenome = $linha['sobrenome'];
    $email = $linha['email'];
} else {
    // Se a consulta não retornou resultados, exibe uma mensagem de erro
    echo "Erro: usuário não encontrado.";
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
    <title>Perfil</title>
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
    <!-- Exibe o nome e email do usuário na tela -->
    <div class="container">
        <div class="form-image">
            <img src="assets/images/img-perfil.svg" alt="Imagem de Perfil">
        </div>
        <div class="form">
            <form action="perfil.php" method="post">
                <div class="form-header">
                    <div class="title">
                        <h1>Perfil</h1>
                    </div>
                    <div class="btn-voltar">
                        <button>
                            <a href="<?= ($_SESSION["rm"] == "08670") ? '../index-adm.php' : '../index.php' ?>" class="button">Voltar</a>
                        </button>
                    </div>
                    <div class="btn-sair">
                        <button>
                            <a href="login.php">Sair</a>
                        </button>

                </div>
                </div>
                <div class="dados">
                  <h1>Dados</h1>
                    <div class="dados-nome"><span>Nome: </span><?php echo $nome . ' ' . $sobrenome; ?></div>
                    <div class="dados-email"><span>Email: </span><?php echo $email; ?></div>
                    <div class="dados-rm"><span>RM: </span><?php echo $rm; ?></div>
                    <div class="btn-alterar-senha">
                        <button>
                            <a href="alterar-senha.php">Alterar senha</a>
                        </button>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
</body>
</html>
