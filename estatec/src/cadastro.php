<?php

include 'conexao.php';

if (empty($_POST['nome']) || empty($_POST['rm']) || empty($_POST['senha']) || empty($_POST['email'])) {
    header('Location: cadastrar.php?error=1');
    exit();
}

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$email = $_POST['email'];
$rm = $_POST['rm'];
$senha = $_POST['senha'];

// Validando RM com 5 dígitos
if (!preg_match('/^\d{5}$/', $rm)) {
    header('Location: cadastrar.php?error=2');
    exit();
}

// Validando o formato do email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: cadastrar.php?error=3');
    exit();
}

// Expressão regular para verificar se a senha possui pelo menos uma letra maiúscula, um dígito numérico e um caractere especial
if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])(?!.*\s).{8,}$/', $senha)) {
    header('Location: cadastrar.php?error=4');
    exit();
}

// Verificar se o usuário já está cadastrado
$verificar_usuario = "SELECT * FROM usuarios WHERE email=? OR rm=?";
$stmt = mysqli_prepare($conn, $verificar_usuario);
mysqli_stmt_bind_param($stmt, 'ss', $email, $rm);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {
    header('Location: ../view/cadastrar.php?error=5');
    exit();
}

// Criptografar a senha
$senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

// Inserir o novo registro
$stmt = $conn->prepare("INSERT INTO usuarios (nome, sobrenome, email, rm, senha) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $nome, $sobrenome, $email, $rm, $senhaCriptografada);
if ($stmt->execute()) {
    echo "Registro inserido com sucesso!";
} else {
    echo "Erro ao inserir registro: " . $stmt->error;
}

header('location: ../view/login.php');
?>
