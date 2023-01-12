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

    try {

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($dados['submit'])) {

            $query_aluno =  "INSERT INTO alunos (nome, sobrenome, email, senha ,data_nascimento ,contato_tel, endereco, created) VALUES(:nome, :sobrenome, :email, :senha,  :data_nascimento, :contato_tel, :endereco,  NOW())";

            $cad_aluno = $conn->prepare($query_aluno);
            $cad_aluno->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
            $cad_aluno->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
            $cad_aluno->bindParam(':data_nascimento', $dados['data_nascimento'], PDO::PARAM_INT);
            $cad_aluno->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $senha_cript = password_hash($dados['senha'], PASSWORD_DEFAULT);
            $cad_aluno->bindParam(':senha', $senha_cript);
            $cad_aluno->bindParam(':endereco', $dados['endereco'], PDO::PARAM_STR);
            $cad_aluno->bindParam(':contato_tel', $dados['contato_tel'], PDO::PARAM_INT);
            $cad_aluno->execute();

            if ($cad_aluno->rowCount()) {
                $_SESSION['mgg'] = "<p style='color:green;'> Aluno cadastrado com sucesso</p>";

                unset($dados);
                header("Location:cadastrar.php");
            } else {
                echo "Aluno nao cadastrado com sucesso";
            }
        }
    } catch (PDOException $erro) {
        //echo "Aluno nao cadastrado com sucesso<br>";
        echo  "Aluno nao cadastrado com sucesso " . $erro->getMessage() . "<br>";
    }
    ?>






    <section id="form">
        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="text-uppercase">Preencha os campos
                        <br>
                        <span class="blue">para cadastar um novo Aluno</span>
                    </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <br><br>



                                <form class="row g-3" action="" method="post">

                                    <div class="col-md-6">
                                        <label class="form-label">Nome</label>
                                        <input type="text" name="nome" class="form-control" id="inputDado" placeholder="Nome" value="<?php if (isset($dados['nome'])) {
                                                                                                                                            echo $dados['nome'];
                                                                                                                                        } ?>" required> <br>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="" class="form-label">Sobrenome</label>
                                        <input type="text" name="sobrenome" class="form-control" id="inputDado" placeholder="Sobrenome" value="<?php if (isset($dados['sobrenome'])) {
                                                                                                                                                    echo $dados['sobrenome'];
                                                                                                                                                } ?>" required> <br>
                                    </div>


                                    <div class="col-md-6">
                                        <label for="" class="form-label">E-mail</label>
                                        <input type="email" name="email" class="form-control" id="inputDado" placeholder="E-mail" value="<?php if (isset($dados['email'])) {
                                                                                                                                                echo $dados['email'];
                                                                                                                                            } ?>" required> <br>
                                    </div>

                                    <div class="col-md-6">

                                        <label for="" class="form-label">Senha</label>
                                        <input type="password" name="senha" class="form-control" id="inputDado" placeholder="Senha" value="<?php if (isset($dados['senha'])) {
                                                                                                                                                echo $dados['senha'];
                                                                                                                                            } ?>" required><br>


                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Data de nascimento</label>
                                        <input type="date" name="data_nascimento" class="form-control" id="inputDado" placeholder="Data de nascimento" value="<?php if (isset($dados['data_nascimento'])) {
                                                                                                                                                                    echo $dados['data_nascimento'];
                                                                                                                                                                } ?>" required> <br>



                                    </div>
                                    <div class="col-md-6">

                                        <label for="" class="form-label">Telefone</label>
                                        <input type="text" name="contato_tel" class="form-control" id="inputDado" placeholder="Telefone" value="<?php if (isset($dados['contato_tel'])) {
                                                                                                                                                    echo $dados['contato_tel'];
                                                                                                                                                } ?>" required> <br>




                                    </div>

                                    <div class="col-12">

                                        <label for="" class="form-label">Endereço</label>
                                        <textarea type="text" name="endereco" class="form-control" id="inputDado" placeholder="Endereço" value=" <?php if (isset($dados['endereco'])) {
                                                                                                                                                        echo $dados['endereco'];
                                                                                                                                                    } ?>" required></textarea><br><br>



                                    </div>

                                    <div class="col-md-12">
                                        <input type="submit" value="Cadastrar" name="submit" class="btn btn-primary" id="inputDado"><br><br>
                                    </div>



                                </form>

                                <div class="col-md-12">
                                    <a class="btn btn-link" href="listar.php">Listar Alunos</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>










</body>

</html>