<?php

session_start();

include_once "conexao.php";

$id = filter_input(INPUT_GET, "aluno_id", FILTER_SANITIZE_NUMBER_INT);

if ($id) {
    try {
        $query_aluno = "DELETE FROM alunos WHERE id=:id LIMIT 1";
        $apagar_aluno = $conn->prepare($query_aluno);
        $apagar_aluno->bindParam(':id', $id, PDO::PARAM_INT);
        if ($apagar_aluno->execute()) {
            $_SESSION["msg"] = "<p style='color:green;'> Aluno apagado com sucessso</p>";
            header('Location:listar.php');
        } else {
            $_SESSION["msg"] = "<p style='color:red;'>Erro: Aluno nao apagado com sucessso</p>";
            header('Location:listar.php');
        }
    } catch (PDOException $erro) {
       $_SESSION["msg"] = "<p style='color:red;'>Erro: Aluno nao apagado com sucessso</p>";
        //$_SESSION["msg"] = "<p style='color:red;'>Erro: Aluno nao apagado com sucessso ". $erro->getMessage() ."</p>";
        header('Location:listar.php');
    }
} else {
    $_SESSION["msg"] = "<p style='color:red;'>Erro: Aluno nao encontrado</p>";
    header('Location:listar.php');
}


?>