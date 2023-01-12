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
    <title>Listar Alunos</title>
</head>

<body>



    <?php

    if (isset($_SESSION["msg"])) {
        echo $_SESSION["msg"];
        unset($_SESSION["msg"]);
    }


    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    ?>

    <section id="form" class="border">
        <div class="container pt-5 pb-5 ">
            <div class="row"></div>
            <div class="col-md-12 text-center">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <br><br>

                            <form class="row g-3 " action="" method="post">

                                <div class="col-md-8 text-center">

                                    <h3 class="text-uppercase">
                                        <span class="blue">Pesquisar Alunos</span>
                                    </h3>
                                    <br>
                                </div>

                                <?php
                                $pesquisar_aluno = "";
                                if (isset($dados['pesquisar_aluno'])) [
                                    $pesquisar_aluno = $dados['pesquisar_aluno']
                                ]
                                ?>
                                <div class="col-md-8 ">
                                    <label class="form-label" for=""></label>
                                    <input type="text" name="pesquisar_aluno" class="form-control" id="inputDado" value="<?php echo $pesquisar_aluno; ?>" placeholder="Pesquisar aluno"><br>
                                </div>

                                <div class="col-md-8">
                                    <input type="submit" name="pesquisar" value="Pesquisar" class="btn btn-primary" id="inputDado">
                                </div>
                                <br><br>
                                <div class="col-md-8 ">
                                    <a class="btn btn-link " href="Cadastrar.php">Cadastrar aluno</a>

                                </div>

                            </form><br><br>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php


    if (!empty($dados['pesquisar'])) {
        $nome = "%" . $dados['pesquisar_aluno'] . "%";
        $query_alunos = "SELECT * FROM alunos WHERE nome LIKE :nome";
        $result_alunos = $conn->prepare($query_alunos);
        $result_alunos->bindParam(':nome', $nome, PDO::PARAM_STR);
        $result_alunos->execute();

        while ($row_aluno = $result_alunos->fetch(PDO::FETCH_ASSOC)) {
            //var_dump($row_aluno );
            extract($row_aluno);
    ?>
            <table class="table table-dark table-striped-columns">
                <thead>
                    <tr>
                        <th scope="col">ID:</th>
                        <th scope="col">Nome:</th>
                        <th scope="col">Sobrenome:</th>
                        <th scope="col">E-mail:</th>
                        <th scope="col">Senha:</th>
                        <th scope="col">Data de Nascimento:</th>
                        <th scope="col">Telefone:</th>
                        <th scope="col">Endereço:</th>
                        <th scope="col">Data cadastro:</th>
                        <th scope="col">Cadastro modificado: </th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td> <?php echo $row_aluno['id_aluno']; ?></td>
                        <td> <?php echo  $row_aluno['nome']; ?></td>
                        <td> <?php echo  $row_aluno['sobrenome']; ?></td>
                        <td> <?php echo $row_aluno['email']; ?></td>
                        <td> <?php echo  $row_aluno['senha']; ?></td>
                        <td> <?php echo  date('d/m/Y', strtotime($row_aluno['data_nascimento'])); ?></td>
                        <td> <?php echo  $row_aluno['contato_tel']; ?></td>
                        <td> <?php echo  $row_aluno['endereco']; ?></td>
                        <td><?php echo  date('d/m/Y h:i:s', strtotime($row_aluno['created'])); ?></td>
                        <td> <?php echo $row_aluno['modified'];
                                if (!empty($row_aluno['modified'])) {
                                    echo (date('d/m/Y h:i:s', strtotime($row_aluno['modified'])));
                                } ?></td>
                        <div class="col-md-8 ">
                            <?php echo "<a class='btn btn-outline-warning' href='editar.php?aluno_id=$id_aluno'>Editar</a>" ?>
                            <?php echo   "<a class='btn btn-outline-danger' href='apagar.php?aluno_id=$id_aluno'>Apagar</a>" ?>
                        </div>

                    </tr>


                </tbody>

            </table>

    <?php
        }
    } else {
        echo "Preencha o campo Pesquisar para listar os Alunos";
    }
    ?>

</body>

</html>