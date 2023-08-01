<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION["rm"])) {
    header("Location: ../view/login.php");
    exit();
}

include ('../src/conexao.php');

// Recupera o ID do estágio do parâmetro da URL
$id = $_GET['id'];

// Consulta para recuperar as informações do estágio pelo ID
$sql = "SELECT * FROM estagios WHERE id = $id";
$resultado = mysqli_query($conn, $sql);
$estagio = mysqli_fetch_assoc($resultado);

// Verifica se o estágio foi encontrado
if (!$estagio) {
    // Redireciona de volta para a página de lista de estágios se o estágio não existir
    header("Location: ../view/estagios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estagio.css">
    <link rel="shortcut icon" href="assets/images/Logo-03.1.ico" type="image/x-icon">
    <title>Detalhes do Estágio</title>
</head>
<body>
    <header>
    <a href="https://etecfernandopolis.com.br/site/inicio/" target="_blank">
    <img class="logo-etec" src="../view/assets/images/logoEtec.svg" alt="Logo da ETEC de Fernandópolis">
    </a>
        <div class="header-links">
            <a href="<?= ($_SESSION["rm"] == "08670") ? 'estagios-adm.php' : 'estagios.php'?>">Estágios</a>
            <a href="<?= ($_SESSION["rm"] == "08670") ? '../index-adm.php' : '../index.php'?>">Sobre</a>
            <a href="dicas.php">Dicas</a>
            <button><a href="perfil.php">PERFIL</a></button>
        </div>
        </header>
    <main>
        <h1>Detalhes do Estágio</h1>
        <div class="info">
            <div class="estagio-details">
                <h2><?php echo $estagio['nome']; ?></h2>
                <p><strong>Categoria:</strong> <?php echo $estagio['categoria']; ?></p>
                <p><strong>Assunto:</strong> <?php echo $estagio['assunto']; ?></p>
                <p><strong>Requisitos:</strong> <?php echo $estagio['requisitos']; ?></p>
                <p><strong>Carga Horária:</strong> <?php echo $estagio['carga_horaria']; ?></p>
                <p><strong>Atividades:</strong> <?php echo $estagio['atividades']; ?></p>
                <p><strong>Salário:</strong> <?php echo $estagio['salario']; ?></p>
                <p><strong>Data de Validade:</strong> <?php echo $estagio['data_validade']; ?></p>
                <div class="buttons">
                    <a href="<?= ($_SESSION["rm"] == "08670") ? 'estagios-adm.php' : 'estagios.php' ?>" class="button">Voltar para a Lista de Estágios</a>
                    <a href="enviar-curriculo.php?id=<?php echo $id; ?>" class="button">Enviar Currículo</a>
                </div>
            </div>
            <div class="img-main">
                <img src="assets/images/lista-de-estagios-img.svg" alt="Imagem Página de Detalhes">
            </div>
        </div>
        
    </main>

</body>
</html>

<?php
// Encerra a conexão com o banco de dados
mysqli_close($conn);
?>