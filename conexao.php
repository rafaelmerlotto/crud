<?php

use PgSql\Lob;
//inicio da conexao com o banco de dados ultillizando o PDO

$host = "localhost";
$user = "rafael";
$pass = "basiliko";
$dbname = "test";


try {
    $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);
   // echo "<h1>conexao com o banco de dados realizado com sucesso</h1>";
} catch (PDOException $err) {
    echo "Erro: conexao com banco de dados nao foi realizado com sucesso. Erro gerado" . $err->getMessage();
}

//fim da conexao com o bannco de dados ultilizando o PDO


?>