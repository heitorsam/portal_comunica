<?php

    include '../conexao.php';

    $id_grupo = $_POST['id_grupo'];

    // DELETA TODOS OS USUARIOS DA TABELA GRUPO USUARIOS
    $query_deleta_usuarios_grupo = "DELETE FROM portal_comunica.GRUPO_USUARIO
                                    WHERE CD_GRUPO = $id_grupo";

    mysqli_query($conn, $query_deleta_usuarios_grupo);

    // DELETA O GRUPO
    $query_deleta_grupo = "DELETE FROM portal_comunica.GRUPO
                           WHERE CD_GRUPO = $id_grupo";

    mysqli_query($conn, $query_deleta_grupo);

?>