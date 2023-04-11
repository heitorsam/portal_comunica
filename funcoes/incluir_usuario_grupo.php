<?php

    session_start();
    include '../conexao.php';

    $cd_usuairo_logado = $_SESSION['cd_usu'];

    $id_usuario_grupo = $_POST['id_usuario_grupo'];
    $id_grupo = $_POST['id_grupo'];

    $query_inserir_usuario_grupo = "INSERT INTO portal_comunica.GRUPO_USUARIO (CD_GRUPO_USUARIO,
                                                                                CD_GRUPO,
                                                                                CD_USUARIO,
                                                                                CD_USUARIO_CADASTRO,
                                                                                HR_CADASTRO)
                                                                                VALUES (
                                                                                NULL,
                                                                                $id_grupo,
                                                                                $id_usuario_grupo,
                                                                                $cd_usuairo_logado,
                                                                                NOW())";
    
    mysqli_query($conn, $query_inserir_usuario_grupo);
                             
?>