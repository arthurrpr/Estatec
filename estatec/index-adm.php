<?php
// inclui o arquivo de conexão com o banco de dados
include ('src/conexao.php');

// inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["rm"])) {
    header("Location: ../view/login.php");
    exit();
}

// Verifica se o RM é igual a "08670"
if ($_SESSION["rm"] !== "08670") {
    header("Location: ../estatec/view/acesso-negado.php"); // Página de acesso negado
    exit();
}

// Obtém o RM da sessão
$rm = $_SESSION["rm"];

// Monta a consulta SQL para recuperar o nome do usuário a partir do RM
$sql = "SELECT nome FROM usuarios WHERE rm = $rm";

// Executa a consulta SQL
$resultado = mysqli_query($conn, $sql);

// Verifica se a consulta retornou resultados
if (mysqli_num_rows($resultado) > 0) {
    // Obtém o array associativo com os resultados da consulta
    $linha = mysqli_fetch_assoc($resultado);

    // Armazena o nome do usuário em uma variável
    $nome = $linha['nome'];
} else {
    // Se a consulta não retornou resultados, exibe uma mensagem de erro
    echo "Erro: usuário não encontrado.";
}

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/assets/css/index.css">
    <script src="assets/js/index.js"></script>
    <link rel="shortcut icon" href="view/assets/images/Logo-03.1.ico" type="image/x-icon">
    <title>ESTATEC</title>
</head>
<body>
    <header>
    <a href="https://etecfernandopolis.com.br/site/inicio/" target="_blank">
    <img class="logo-etec" src="view/assets/images/logoEtec.svg" alt="Logo da ETEC de Fernandópolis">
    </a>
       <div class="header-links">
           <a href="<?= ($_SESSION["rm"] == "08670") ? '../estatec/view/estagios-adm.php' : '../estatec/view/estagios.php'?>">Estágios</a>
           <a href="#sobre">Sobre</a>
           <a href="view/dicas.php">Dicas</a>
           <button class="header-perfil"><a href="view/perfil.php">PERFIL</a></button>
       </div>
    </header>
    <main>
    <div class="info">
    <img src="view/assets/images/ESTATEC-LOGO.png" alt="Logo Estatec">
        <div class="text-main">
            <h1>
                OLÁ, <span><?php echo $nome;?></span>,
                SEJA BEM VINDO AO ESTATEC!
            </h1>
            <p>
                Caso tenha dúvidas sobre como estagiar e o que é 
                necessário para estagiar, vá para área de Dicas. 
                Acesse a aba Sobre se tiver a procura de informações 
                sobre o contato dos desenvolvedores.
            </p>
            
        </div>
    </div>
        <img src="view/assets/images/index/img-index.svg" alt="Imagem da Página Inicial">
    </main>
    <section id="sobre">
        <h1>SOBRE O ESTATEC</h1>
        <p>
            ESTATEC é um site gerenciador de estágios, criado por
            um grupo de estudantes da ETEC Fernandópolis. O website foi idealizado com 
            intuito de uma melhor organização de oportunidades de trabalho de estágios 
            oferecidos pela instituição.
        </p>
    </section>
    <footer>
        <div class="contacts-footer">
            <p class="contacts-title">CONTATO</p>
            <div class="local-footer">
                <img src="view/assets/images/index/local-footer.png" alt="Endereço da ETEC">
                <p>
                    Av. Geraldo Roquete, 135 - <br>
                    Jardim Paulista, <br>
                    Fernandópolis - SP, 15606-020
                </p>
            </div>
        </div>
        <div class="numbers-footer">
            <p> <img src="view/assets/images/index/phone-footer.png" alt="Icon de telefone"> (17)3462-3030</p>
            <p><img src="view/assets/images/index/phone-footer.png" alt="Icon de telefone"> (17)3462-3311</p>
            <p>
                <img src="view/assets/images/index/app-footer.png" alt="Icon do Whatsapp"> (17)99612-7627 <br>
                WhatsApp (Somente mensagens)
            </p>
        </div>
    </footer>
</body>
</html>
