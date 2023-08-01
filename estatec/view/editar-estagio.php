<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION["rm"])) {
    header("Location: ../view/login.php");
    exit();
}

// Verifica se o RM é igual a "08670"
if ($_SESSION["rm"] !== "08670") {
    header("Location: ../view/acesso-negado.php"); // Página de acesso negado
    exit();
}

include('../src/conexao.php');

// Verifica se foi fornecido um ID válido para o estágio a ser editado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idEstagio = $_GET['id'];

    // Verifica se o estágio existe no banco de dados
    $sql = "SELECT * FROM estagios WHERE id = $idEstagio";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        // Obtém os dados do estágio
        $estagio = mysqli_fetch_assoc($resultado);
    } else {
        // Redireciona para a lista de estágios caso o estágio não seja encontrado
        header("Location: estagios.php");
        exit();
    }
} else {
    // Redireciona para a lista de estágios caso o ID não seja fornecido
    header("Location: estagios.php");
    exit();
}

// Verifica se o formulário foi submetido para atualizar o estágio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $assunto = $_POST['assunto'];
    $dataValidade = $_POST['data_validade'];
    $categoria = $_POST['categoria'];
    $requisitos = $_POST['requisitos'];
    $cargaHoraria = $_POST['carga_horaria'];
    $atividades = $_POST['atividades'];
    $salario = $_POST['salario'];
    

    // Atualiza o estágio no banco de dados
    $sql = "UPDATE estagios SET nome = '$nome', assunto = '$assunto', data_validade = '$dataValidade', categoria = '$categoria', requisitos = '$requisitos', carga_horaria = '$cargaHoraria', atividades = '$atividades', salario = '$salario' WHERE id = $idEstagio";

    if (mysqli_query($conn, $sql)) {
        // Redireciona para a página correta após a atualização
        if ($_SESSION["rm"] == "08670") {
            header("Location: estagios-adm.php");
        } else {
            header("Location: estagios.php");
        }
        exit();
    } else {
        // Exibe uma mensagem de erro em caso de falha na atualização
        $mensagemErro = "Erro ao atualizar o estágio: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/editar-estagio.css">
    <link rel="shortcut icon" href="assets/images/Logo-03.1.ico" type="image/x-icon">
    <title>Editar Estágio</title>
</head>
<body>
    <header>
    <a href="https://etecfernandopolis.com.br/site/inicio/" target="_blank">
    <img class="logo-etec" src="../view/assets/images/logoEtec.svg" alt="Logo da ETEC de Fernandópolis">
    </a>
        <div class="header-links">
            <a href="estagios.php">Estágios</a>
            <a href="<?= ($_SESSION["rm"] == "08670") ? '../index-adm.php' : '../index.php'?>">Sobre</a>
            <a href="dicas.php">Dicas</a>
            <button><a href="view/perfil.php">PERFIL</a></button>
        </div>
    </header>
    <main>
        <h1>Editar Estágio</h1>

        <?php if (isset($mensagemErro)) { ?>
            <p><?php echo $mensagemErro; ?></p>
        <?php } ?>

        <div class="info">
            <form method="POST" action="">
                <div class="estagio-details">
                <div class="nome">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo $estagio['nome']; ?>" placeholder="Nome do estágio" required>
                </div>
                <div class="assunto-validade">
                    <div class="assunto">
                        <label for="assunto">Assunto:</label>
                        <input type="text" id="assunto" name="assunto" value="<?php echo $estagio['assunto']; ?>" required>
                    </div>
                    <div class="data-validade">
                        <label for="data_validade">Validade:</label>
                        <input type="date" id="data_validade" name="data_validade" value="<?php echo $estagio['data_validade']; ?>" required>
                    </div>
                </div>
                <div class="categoria-requisitos">
                    <div class="categoria">
                        <label for="categoria">Categoria:</label>
                        <input type="text" id="categoria" name="categoria" value="<?php echo $estagio['categoria']; ?>" required>
                    </div>
                    <div class="requisitos">
                        <label for="requisitos">Requisitos:</label>
                        <input type="text" id="requisitos" name="requisitos" value="<?php echo $estagio['requisitos']; ?>" required>
                    </div>
                </div>
                <div class="carga-horaria">
                    <label for="carga_horaria">Carga Horária:</label>
                    <input type="text" id="carga_horaria" name="carga_horaria" value="<?php echo $estagio['carga_horaria']; ?>" required>
                </div>
                <div class="atividades">
                    <label for="atividades">Principais Atividades:</label>
                    <input type="text" id="atividades" name="atividades" value="<?php echo $estagio['atividades']; ?>" required>
                </div>
                <div class="salario">
                    <label for="salario">Salário:</label>
                    <input type="text" id="salario" name="salario" value="<?php echo $estagio['salario']; ?>" required>
                </div>

                </div>

                <input type="submit" name="atualizar" value="Atualizar" class="atualizar">

                <?php if ($_SESSION["rm"] == "08670") { ?>
                <button class="back"><a href="estagios-adm.php" class="button">Voltar para a Lista de Estágios</a></button>
                <?php } else { ?>
                <button class="back"><a href="estagios.php" class="button">Voltar para a Lista de Estágios</a></button>
                <?php } ?>

            </form>
            <div class="image">
                <img src="assets/images/img-editar-estagio.svg" alt="Imagem de Editar Cadastro">
            </div>
        </div>
    </main>

</body>
</html>

<?php
// Encerra a conexão com o banco de dados
mysqli_close($conn);
?>
