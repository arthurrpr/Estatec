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

// Verifica se foi solicitada a exclusão de um estágio
if (isset($_GET['excluir']) && !empty($_GET['excluir'])) {
    $idExcluir = $_GET['excluir'];

    // Exclui o estágio do banco de dados
    $excluirEstagio = "DELETE FROM estagios WHERE id=?";
    $stmt = mysqli_prepare($conn, $excluirEstagio);
    mysqli_stmt_bind_param($stmt, 'i', $idExcluir);
    mysqli_stmt_execute($stmt);

    // Verifica se a exclusão foi realizada com sucesso
    if (mysqli_affected_rows($conn) > 0) {
        header("Location: estagios-adm.php");
        exit();
    } else {
        echo "Erro ao excluir o estágio.";
    }

    mysqli_stmt_close($stmt);
}

// Consulta para recuperar todas as categorias existentes no banco de dados
$sqlCategorias = "SELECT DISTINCT categoria FROM estagios";
$resultadoCategorias = mysqli_query($conn, $sqlCategorias);

// Define a categoria selecionada (se houver)
$categoriaSelecionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Consulta para recuperar os estágios filtrados pela categoria selecionada
$sqlEstagios = "SELECT * FROM estagios";
if (!empty($categoriaSelecionada)) {
    $sqlEstagios .= " WHERE categoria='$categoriaSelecionada'";
}
$resultadoEstagios = mysqli_query($conn, $sqlEstagios);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estagios.css">
    <link rel="shortcut icon" href="assets/images/Logo-03.1.ico" type="image/x-icon">
    <title>Lista de Estágios</title>
</head>
<body>
    <header>
    <a href="https://etecfernandopolis.com.br/site/inicio/" target="_blank">
            <img class="logo-etec" src="../view/assets/images/logoEtec.svg" alt="Logo da ETEC de Fernandópolis">
        </a>
        <div class="header-links">
            <a href="estagios-adm.php">Estágios</a>
            <a href="../index-adm.php">Sobre</a>
            <a href="dicas.php">Dicas</a>
            <button><a href="perfil.php">PERFIL</a></button>
        </div>
    </header>
    <h1>Lista de Estágios</h1>
    <div class="filtro">
        <label class="filtro-container" for="categoria">Filtrar por Categoria:</label>
        <select name="categoria" id="categoria" onchange="filtrarEstagios(this.value)">
            <option value="">Todas as categorias</option>
            <?php while ($categoria = mysqli_fetch_assoc($resultadoCategorias)) { ?>
                <option value="<?php echo $categoria['categoria']; ?>" <?php if ($categoria['categoria'] === $categoriaSelecionada) echo 'selected'; ?>>
                    <?php echo $categoria['categoria']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <table>
        <thead>
            <tr> 
                <th>Nome</th>
                <th>Assunto</th>
                <th>Categoria</th>
                <th>Data de Validade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($estagio = mysqli_fetch_assoc($resultadoEstagios)) { ?>
            <tr class="fundoestagio" data-id="<?php echo $estagio['id']; ?>">
                <td><?php echo $estagio['nome']; ?></td>
                <td><?php echo $estagio['assunto']; ?></td>
                <td><?php echo $estagio['categoria']; ?></td>
                <td><?php echo $estagio['data_validade']; ?></td>
                <td>
                    <div class="editar-excluir">
                        <a href="editar-estagio.php?id=<?php echo $estagio['id']; ?>">
                            <button>
                                <img src="assets/images/pencil-list.png" alt="Editar">
                            </button>
                        </a>
                        <a href="estagios-adm.php?excluir=<?php echo $estagio['id']; ?>" onclick="return confirm('Tem certeza de que deseja excluir este estágio?')">
                            <button>
                                <img src="assets/images/trash-list.png" alt="Excluir">
                            </button>
                        </a>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="cadastrar-estagio.php" class="button">CADASTRAR ESTÁGIO</a>

    <script>
        function filtrarEstagios(categoria) {
            window.location.href = 'estagios-adm.php?categoria=' + encodeURIComponent(categoria);
        }
    </script>

<script src="assets/js/estagios.js"></script>

</body>
</html>

<?php
// Encerra a conexão com o banco de dados
mysqli_close($conn);
?>
