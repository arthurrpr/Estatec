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

// Monta a consulta SQL para buscar o campo "nome" da tabela "estagios"
$sql = "SELECT nome FROM estagios";

$resultado = mysqli_query($conn, $sql);

// Verifica se a consulta retornou resultados
if (mysqli_num_rows($resultado) > 0) {
    // Obtém o array associativo com os resultados da consulta
    $linha = mysqli_fetch_assoc($resultado);

    // Armazena o nome do estagio em uma variável
    $estagio = $linha['nome'];
} else {
    // Se a consulta não retornou resultados, exibe uma mensagem de erro
    echo "Erro: estágio não encontrado.";
}

// Verifica se foi enviado um currículo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['curriculo'])) {
    // Verifica se não houve erro no upload do arquivo
    if ($_FILES['curriculo']['error'] === UPLOAD_ERR_OK) {
        $nomeArquivo = $_FILES['curriculo']['name'];
        $caminhoArquivo = $_FILES['curriculo']['tmp_name'];

        // Endereço de e-mail para onde será enviado o currículo
        $emailDestino = 'ariel.aio@etec.sp.gov.br';

        // Cabeçalhos do e-mail
        $headers = "From: gabriel.baria@etec.sp.gov.br\r\n";
        $headers .= "Reply-To: ariel.aio@etec.sp.gov.br\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

        // Mensagem do e-mail
        $mensagem = "--boundary\r\n";
        $mensagem .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
        $mensagem .= "Content-Transfer-Encoding: 7bit\r\n";
        $mensagem .= "\r\n";
        $mensagem .= "Segue em anexo o currículo enviado pelo candidato.\r\n";
        $mensagem .= "\r\n";
        $mensagem .= "--boundary\r\n";
        $mensagem .= "Content-Type: application/pdf; name=\"$nomeArquivo\"\r\n";
        $mensagem .= "Content-Transfer-Encoding: base64\r\n";
        $mensagem .= "Content-Disposition: attachment; filename=\"$nomeArquivo\"\r\n";
        $mensagem .= "\r\n";
        $mensagem .= chunk_split(base64_encode(file_get_contents($caminhoArquivo))) . "\r\n";
        $mensagem .= "\r\n";
        $mensagem .= "--boundary--";

        // Envia o e-mail com o currículo anexado
        if (mail($emailDestino, 'Currículo', $mensagem, $headers)) {
            $mensagemSucesso = "O currículo foi enviado com sucesso.";

            // Envia mensagem de sucesso para a tela
            echo "<script>alert('{$mensagemSucesso}')</script>";

        } else {
            $mensagemErro = "Ocorreu um erro ao enviar o currículo.";

            // Envia mensagem de erro para a tela
            echo "<script>alert('{$mensagemErro}')</script>";
        }
    } else {
        $mensagemErro = "Ocorreu um erro no upload do currículo.";

        // Envia mensagem de erro para a tela
        echo "<script>alert('{$mensagemErro}')</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="assets/images/Logo-03.1.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/enviar-curriculo.css">
    <title>Enviar Currículo</title>
</head>
<body>
    <header>
    <a href="https://etecfernandopolis.com.br/site/inicio/" target="_blank">
    <img class="logo-etec" src="../view/assets/images/logoEtec.svg" alt="Logo da ETEC de Fernandópolis">
    </a>
        <div class="header-links">
            <a href="estagios.php">Estágios</a>
            <a href="#sobre">Sobre</a>
            <a href="dicas.php">Dicas</a>
            <button><a href="perfil.php">PERFIL</a></button>
        </div>
    </header>
    <main>
        <h1 class="titulo">Enviar Currículo</h1>

        <div class="info">

            <div class="enviar-curriculo">
                <h2><?php echo $estagio; ?></h2>
                <?php if (isset($mensagemSucesso)) { ?>
                    <p class="sucesso"><?php echo $mensagemSucesso; ?></p>
                <?php } ?>
                <?php if (isset($mensagemErro)) { ?>
                    <p class="erro"><?php echo $mensagemErro; ?></p>
                <?php } ?>
                <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST' || isset($mensagemErro)) { ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="pdf">
                            <label for="curriculo">Selecione seu currículo em formato PDF:</label>
                            <input class="escolher-arquivo" type="file" id="curriculo" name="curriculo" accept="application/pdf" required>
                            <button type="submit" class="button">Enviar</button>
                        </div>

                        <p>
                        Não sabe como criar seu currículo? 
                        <a href="dicas.php">Clique aqui</a> ou acesse a aba de Dicas!
                        </p>

                        <a href="<?= ($_SESSION["rm"] == "08670") ? 'estagios-adm.php' : 'estagios.php' ?>" class="button-voltar">Voltar para a Lista de Estágios</a>
                    </form>
                <?php } elseif (isset($_FILES['curriculo'])) {
                    // Mova o arquivo enviado para um diretório acessível pelo navegador
                    $diretorioDestino = "uploads/";
                    $caminhoDestino = $diretorioDestino . $_FILES['curriculo']['name'];
                    move_uploaded_file($_FILES['curriculo']['tmp_name'], $caminhoDestino);
                ?>
                    <embed src="<?php echo $caminhoDestino; ?>" type="application/pdf" width="100%" height="600px">
                <?php } ?>
            </div>

            <div class="image">
                <img src="assets/images/img-enviar-curriculo.svg" alt="Imagem da Página de Enviar Currículo">
            </div>

        </div>
    </main>
    
</body>
</html>


<?php
// Encerra a conexão com o banco de dados
mysqli_close($conn);
?>
    