<?php
session_start();
include_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Cadastrar Aluno</title>
</head>

<body>

    <?php

    if (isset($_SESSION["msg"])) {
        echo $_SESSION["msg"];
        unset($_SESSION["msg"]);
    }

    try {

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($dados['submit'])) {

            $query_aluno =  "INSERT INTO alunos (nome, sobrenome, email, senha ,id_curso, created) VALUES(:nome, :sobrenome, :email, :senha,  :id_curso,  NOW())";

            $cad_aluno = $conn->prepare($query_aluno);
            $cad_aluno->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
            $cad_aluno->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
            $cad_aluno->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $senha_cript = password_hash($dados['senha'], PASSWORD_DEFAULT);
            $cad_aluno->bindParam(':senha', $senha_cript);
            $cad_aluno->bindParam(':id_curso', $dados['id_curso'], PDO::PARAM_INT);
            $cad_aluno->execute();

            if ($cad_aluno->rowCount()) {

                $_SESSION['msg'] = "<p style='color:green;'> Aluno cadastrado com sucesso</p>";
                header("Location:cadastrar.php");
                unset($dados);
            } else {
                echo "Aluno nao cadastrado com sucesso";
            }
        }
    } catch (PDOException $erro) {
        //echo "Aluno nao cadastrado com sucesso<br>";
        echo  "Aluno nao cadastrado com sucesso " . $erro->getMessage() . "<br>";
    }
    ?>

    <div class="container text-center">
        <div class="row justify-content-center ">
            <div class="col-6">
                <form class="row g-3 " action="" method="post">

                    <div class="col-md-12 p-4">
                        <h3 class="text-uppercase text-center">
                            <span class="blue">Cadastrar Alunos</span>
                        </h3><br>
                    </div>

                    <div class="col-md-12 ">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" id="inputDado" placeholder="Nome" value="<?php if (isset($dados['nome'])) {
                                                                                                                            echo $dados['nome'];
                                                                                                                        } ?>" required> <br>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Sobrenome</label>
                        <input type="text" name="sobrenome" class="form-control" id="inputDado" placeholder="Sobrenome" value="<?php if (isset($dados['sobrenome'])) {
                                                                                                                                    echo $dados['sobrenome'];
                                                                                                                                } ?>" required> <br>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" id="inputDado" placeholder="E-mail" value="<?php if (isset($dados['email'])) {
                                                                                                                                echo $dados['email'];
                                                                                                                            } ?>" required> <br>
                    </div>

                    <div class="col-md-12">

                        <label for="" class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" id="inputDado" placeholder="Senha" value="<?php if (isset($dados['senha'])) {
                                                                                                                                echo $dados['senha'];
                                                                                                                            } ?>" required><br>

                        <?php
                        $query_curso_aluno =  "SELECT id, nome FROM cursos ORDER BY nome ASC";
                        $result_curso_aluno = $conn->prepare($query_curso_aluno);
                        $result_curso_aluno->execute();
                        ?>
                        <div class="col-md-14">
                            <label class="form-label">Curso:</label>
                            <select class="form-control" id="inputDado" name="id_curso" required>
                                <option class="form-control" value="">Selecione</option>
                                <?php
                                while ($row_curso_aluno = $result_curso_aluno->fetch(PDO::FETCH_ASSOC)) {
                                    $select_curso_aluno = "";
                                    if (isset($dados['id_curso']) and ($dados['id_curso'] == $row_curso_aluno['id'])) {
                                        $select_curso_aluno = "selected";
                                    }

                                    echo " <option value='" . $row_curso_aluno['id'] . "'$select_curso_aluno>" . $row_curso_aluno['nome'] . "</option>";
                                }
                                ?>
                            </select> <br><br>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <input type="submit" value="Cadastrar" name="submit" class="btn btn-primary text-center" id="inputDado"><br><br>
                    </div>

                </form>

                <div class="col-md-12">
                    <a class="btn btn-link" href="listar.php">← Listar Alunos</a>
                </div>

            </div>
        </div>
    </div>










</body>

</html>