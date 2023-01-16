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
    <title>Editar Alunos</title>
</head>

<body>



    <?php

    if (isset($_SESSION["msg"])) {
        echo $_SESSION["msg"];
        unset($_SESSION["msg"]);
    }



    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['submit'])) {
        try {
            $query_edit_aluno = "UPDATE alunos SET nome=:nome, sobrenome=:sobrenome, email=:email, senha=:senha, id_curso=:id_curso, modified = NOW() WHERE id=:id";
            $edit_aluno = $conn->prepare($query_edit_aluno);
            $edit_aluno->bindParam(':id', $dados['id'], PDO::PARAM_INT);
            $edit_aluno->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
            $edit_aluno->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
            $edit_aluno->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $senha_cript = password_hash($dados['senha'], PASSWORD_DEFAULT);
            $edit_aluno->bindParam(':senha', $senha_cript, PDO::PARAM_STR);
            $edit_aluno->bindParam(':id_curso', $dados['id_curso'], PDO::PARAM_INT);



            if ($edit_aluno->execute()) {
                $_SESSION["msg"] = "<p style='color:green;'> Aluno editado com sucesso</p>";
                header('Location:editar.php');
            } else {
                echo "Erro: Aluno não editado com sucesso!";
            }
        } catch (PDOException $erro) {
            echo "Erro: Aluno não editado com sucesso!";
            // echo "Erro: Aluno não editado com sucesso ". $erro->getMessage();
        }
    }
    //Receber o id pela URL utilizando o método GET

    $id = filter_input(INPUT_GET, "aluno_id", FILTER_SANITIZE_NUMBER_INT);



    //Pesquisar as informações do usuário no banco de dados

    try {
        $query_aluno = "SELECT id, nome, sobrenome, email, senha, id_curso FROM alunos  WHERE id=:id LIMIT 1";
        $result_aluno = $conn->prepare($query_aluno);
        $result_aluno->bindParam(':id', $id, PDO::PARAM_INT);

        $result_aluno->execute();
        $row_aluno = $result_aluno->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $erro) {
        $_SESSION["msg"] = "<p style='color:red;'>Erro: Aluno não editado com sucesso</p>";
        header('Location:listar.php');
        //echo "Erro: Aluno não editado com sucesso". $erro->getMessage();

    }

    ?>




    <section id="form">
        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-md-12 text-center">


                    <h3 class="text-uppercase">
                        <span class="blue">Editar um aluno</span>
                    </h3>
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <br><br>



                                <form class="row g-3" method="post" action="">


                                    <?php
                                    $id = "";
                                    if (isset($row_aluno['id'])) {
                                        $id = $row_aluno['id'];
                                    }
                                    ?>
                                    <input type="hidden" name="id" class="form-control" id="inputDado" value="<?php echo $id; ?>" required>


                                    <?php
                                    $nome = "";
                                    if (isset($row_aluno['nome'])) {
                                        $nome = $row_aluno['nome'];
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <label class="form-label">Nome: </label>
                                        <input type="text" name="nome" placeholder="Nome" class="form-control" id="inputDado" value="<?php echo $nome; ?>" required><br>
                                    </div>

                                    <?php
                                    $sobrenome = "";
                                    if (isset($row_aluno['sobrenome'])) {
                                        $sobrenome = $row_aluno['sobrenome'];
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <label class="form-label">Sobrenome o curso: </label>
                                        <input type="text" name="sobrenome" placeholder="Sobrenome" class="form-control" id="inputDado" value="<?php echo $sobrenome; ?>" required><br>
                                    </div>

                                    <?php
                                    $email = "";
                                    if (isset($row_aluno['email'])) {
                                        $email = $row_aluno['email'];
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <label class="form-label">E-mail: </label>
                                        <input type="email" name="email" placeholder="O melhor e-mail do usuario" class="form-control" id="inputDado" value="<?php echo $email; ?>" required><br>
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label">Senha: </label>
                                        <input type="password" name="senha" class="form-control" id="inputDado" placeholder="Nova senha para o usuário" required><br>
                                    </div>


                                    <?php
                                    $query_curso_aluno = "SELECT id, nome, professor FROM cursos ";
                                    $result_curso_aluno = $conn->prepare($query_curso_aluno);
                                    $result_curso_aluno->execute();
                                    ?>
                                   <div class="col-md-6">
                                        <label class="form-label">Cursos: </label>
                                        <select class="form-control" id="inputDado"  name="id_curso">
                                            <option value="">Selecione</option>
                                            <?php
                                            while ($row_curso_aluno = $result_curso_aluno->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row_curso_aluno);
                                                $select_curso_aluno = "";
                                                if (isset($dados['id_curso']) and ($dados['id_curso'] == $id)) {
                                                    $select_curso_aluno = "selected";
                                                } elseif (((!isset($dados['id_curso'])) and (isset($row_aluno['id_curso']))) and ($row_aluno['id_curso'] == $id)) {
                                                    $select_curso_aluno = "selected";
                                                }
                                                echo "<option value='$id'$select_curso_aluno>$nome</option>";
                                            }
                                            ?>
                                             <br><br>
                                        </select>
                                        </div>
                                       
                                   

                                    <div class="col-md-12">
                                        <input type="submit" value="Salvar" name="submit" class="btn btn-primary" id="inputDado"><br><br>
                                    </div>


                                </form>
                                <div class="col-md-12">
                                    <a class="btn btn-link" href="listar.php"> ← Listar Alunos</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>













</body>

</html>