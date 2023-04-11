<?php

    include '../conexao.php';

    $id_empresa = $_POST['id_empresa'];

    // EXCLUI TODOS OS GRUPOS DA EMPRESA
    $sql_exclui_todos_grupos = "DELETE
                                FROM portal_comunica.GRUPO
                                WHERE CD_EMPRESA = $id_empresa";

    // EXCLUI A EMPRESA
    $sql_exclusao_empresa = "DELETE FROM portal_comunica.EMPRESA
                             WHERE CD_EMPRESA = $id_empresa";

    mysqli_query($conn, $sql_exclui_todos_grupos);

    mysqli_query($conn, $sql_exclusao_empresa);

?>