<?php

include ('../src/conexao.php');

$buscar_cadastro = 'SELECT * FROM usuarios';
$query_cadastros = mysqli_query($conn, $buscar_cadastro);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" conteant="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/cadastrar.css">
  <link rel="shortcut icon" href="assets/images/Logo-03.1.ico" type="image/x-icon">
  <title>Cadastro ESTATEC</title>
</head>

<body>
  <main>
    <div class="container">
      <img src="assets/images/cadastrar-img.svg" alt="Imagem da Página de Cadastro">
      <section>
        <h1>CADASTRE-SE!</h1>
        <form action="../src/cadastro.php" method="post">
          <div class="input-group">
            <div class="nome-sobrenome">
              <div class="nome">
                <input type="text" required="" name="nome" id="nome" autocomplete="off">
                <label for="nome">Primeiro Nome</label>
              </div>
              <div class="sobrenome">
                <input type="text" name="sobrenome" id="sobrenome" required="" autocomplete="off">
                <label for="sobrenome">Sobrenome</label>
              </div>
            </div>
      
            <div class="email-rm">
              <div class="email">
                <input type="email" id="email" name="email" required="" autocomplete="off">
                <label for="email">E-mail</label>
              </div>
              <div class="rm">
                <input type="text" required="" name="rm" id="rm" autocomplete="off">
                <label for="number">RM</label>
              </div>
            </div>
      
      
            <div class="senha-confirmar">
              <div class="senha">
                <input type="password" required="" name="senha" id="senha" autocomplete="off">
                <label for="senha">Senha</label>
              </div>
              <div class="confirmar-senha">
                <input type="password" required="" name="senha_confirmacao" id="senha_confirmacao" autocomplete="off">
                <label for="senha_confirmacao">Confirme sua senha</label>
              </div>
              <p id="alerta-senha"></p>
            </div>

            <input id="cadastrar" class="cadastrar" type="submit" value="CADASTRAR" onclick="return validarSenha();">
          </div>
          <a href="login.php">Já possui uma conta? Faça seu login!</a>
        </form>
        <div class="linha"></div>
      </section>
    </div>
  </main>

  <script src="assets/js/cadastrar.js"></script>

</body>
</html>