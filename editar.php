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





    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['submit'])) {
        try {
            $query_edit_aluno = "UPDATE alunos SET nome=:nome, sobrenome=:sobrenome, email=:email, senha=:senha, data_nascimento=:data_nascimento, contato_tel=:contato_tel, endereco=:endereco, modified = NOW() WHERE id_aluno=:id_aluno";
            $edit_aluno = $conn->prepare($query_edit_aluno);
            $edit_aluno->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
            $edit_aluno->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
            $edit_aluno->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $senha_cript = password_hash($dados['senha'], PASSWORD_DEFAULT);
            $edit_aluno->bindParam(':senha', $senha_cript, PDO::PARAM_STR);
            $edit_aluno->bindParam(':data_nascimento', $dados['data_nascimento'], PDO::PARAM_INT);
            $edit_aluno->bindParam(':contato_tel', $dados['contato_tel'], PDO::PARAM_INT);
            $edit_aluno->bindParam(':endereco', $dados['endereco'], PDO::PARAM_STR);
            $edit_aluno->bindParam(':id_aluno', $dados['id_aluno'], PDO::PARAM_INT);

            if ($edit_aluno->execute()) {
                $_SESSION["msg"] = "<p style='color:green;'> Aluno editado com sucesso</p>";
                header('Location:listar.php');
            } else {
                echo "Erro: Aluno não editado com sucesso!";
            }
        } catch (PDOException $erro) {
            echo "Erro: Aluno não editado com sucesso!";
            // echo "Erro: Aluno não editado com sucesso ". $erro->getMessage();
        }
    }

    //Receber o id pela URL utilizando o método GET

    $id_aluno = filter_input(INPUT_GET, "aluno_id", FILTER_SANITIZE_NUMBER_INT);

  

    //Pesquisar as informações do usuário no banco de dados
    try {
        $query_aluno = "SELECT id_aluno, nome, sobrenome, email, senha, data_nascimento, contato_tel, endereco FROM alunos  WHERE id_aluno=:id_aluno LIMIT 1";
        $result_aluno = $conn->prepare($query_aluno);
        $result_aluno->bindParam(':id_aluno', $id_aluno, PDO::PARAM_INT);
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



                                <form class="row g-3" method="POST" action="">


                                    <?php
                                    $id_aluno = "";
                                    if (isset($row_aluno['id_aluno'])) {
                                        $id = $row_aluno['id_aluno'];
                                    }
                                    ?>
                                    <input type="hidden" name="id_aluno" class="form-control" id="inputDado" value="<?php echo $id_aluno; ?>" required>


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
                                        <label class="form-label">Sobrenome: </label>
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
                                    $data_nascimento = "";
                                    if (isset($row_aluno['data_nascimento'])) {
                                        $data_nascimento = $row_aluno['data_nascimento'];
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <label class="form-label">Data de nascimento: </label>
                                        <input type="date" name="data_nascimento" class="form-control" id="inputDado" value="<?php echo $data_nascimento; ?>" required><br>
                                    </div>


                                    <?php
                                    $contato_tel = "";
                                    if (isset($row_aluno['contato_tel'])) {
                                        $contato_tel = $row_aluno['contato_tel'];
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <label class="form-label">Telefone: </label>
                                        <input type="phone" name="contato_tel" class="form-control" id="inputDado" value="<?php echo $contato_tel; ?>" required><br>
                                    </div>


                                    <?php
                                    $endereco = "";
                                    if (isset($row_aluno['endereco'])) {
                                        $endereco = $row_aluno['endereco'];
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <label class="form-label">Endereço: </label>
                                        <textarea type="text" name="endereco" placeholder="Endereço" class="form-control" id="inputDado" value="<?php echo $endereco; ?>" required></textarea><br><br>
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