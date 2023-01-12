<?php

use PgSql\Lob;
//inicio da conexao com o database ultillizando o PDO

$host = "localhost";
$user = "rafael";
$password = "basiliko";
$dbname = "test";


try {
    $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $password);
   // echo "<h1>conexao com o database realizado com sucesso</h1>";
} catch (PDOException $erro) {
    echo "Erro: conexao com o database nao foi realizado com sucesso" . $erro->getMessage();
    
}

//fim da conexao com o database ultilizando o PDO


?>

