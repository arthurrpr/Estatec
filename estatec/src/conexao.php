<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '123456');
define('DB_NAME', 'estatec');

try {
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if ($conn->connect_error) {
    throw new Exception('Não foi possível conectar ao banco de dados: ' . $conn->connect_error);
  }
}
catch (Exception $e) {
  // Trata o erro de conexão de forma personalizada
  echo $e->getMessage();
  exit();
}

// ... código que utiliza a conexão

?>
