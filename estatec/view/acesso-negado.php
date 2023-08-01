<?php
// inclui o arquivo de conexão com o banco de dados
include ('../src/conexao.php');

// inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["rm"])) {
    header("Location: ../view/login.php");
    exit();
}

// obtém o RM do usuário armazenado na sessão e o sanitiza
$rm = filter_var($_SESSION['rm'], FILTER_SANITIZE_NUMBER_INT);

// verifica se o RM é válido
if (!is_numeric($rm)) {
    die("Erro: RM inválido.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/Logo-03.1.ico" type="image/x-icon">
    <title>Acesso Negado</title>
    <style>
        body {
            background-color: #f8f8f8;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            font-size: 32px;
            color: #ff4d4d;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #555555;
            margin-bottom: 20px;
        }

        .btn-back {
            background-color: #ff4d4d;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #ff3333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Acesso Negado</h1>
        <p>Você não tem permissão para acessar essa página.</p>
        <a href="../index.php" class="btn-back">Voltar para a página inicial</a>
    </div>
</body>
</html>