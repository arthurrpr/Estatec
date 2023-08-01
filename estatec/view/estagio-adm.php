
<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION["rm"])) {
    header("Location: ../view/login.php");
    exit();
}

// Verifica se o RM é igual a "08670"
if ($_SESSION["rm"] !== "08670") {
    header("Location: ../view/acesso-negado.php");
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
    <h1>Detalhes do Estágio</h1>

    <div class="estagio-details">
        <h2><?php echo $estagio['nome']; ?></h2>
        <p><strong>Assunto:</strong> <?php echo $estagio['assunto']; ?></p>
        <p><strong>Requisitos:</strong> <?php echo $estagio['requisitos']; ?></p>
        <p><strong>Carga Horária:</strong> <?php echo $estagio['carga_horaria']; ?></p>
        <p><strong>Atividades:</strong> <?php echo $estagio['atividades']; ?></p>
        <p><strong>Salário:</strong> <?php echo $estagio['salario']; ?></p>
        <p><strong>Data de Validade:</strong> <?php echo $estagio['data_validade']; ?></p>
    </div>

    <a href="estagios.php" class="button">Voltar para a Lista de Estágios</a>

    <a href="enviar_curriculo.php?id=<?php echo $id; ?>" class="button">Enviar Currículo</a>

</body>
</html>

<?php
// Encerra a conexão com o banco de dados
mysqli_close($conn);
?>
