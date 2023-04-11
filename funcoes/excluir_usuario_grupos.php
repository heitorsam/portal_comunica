<?php

    include '../conexao.php';

    $id_usuario = $_POST['id_usuario'];

    // QUERY PARA EXCLUIR TODOS OS REGISTROS EM GRUPO DO USUÁRIO EXCLUÍDO
    $cons_exclui_usuario = "DELETE
                            FROM portal_comunica.GRUPO_USUARIO
                            WHERE CD_USUARIO = $id_usuario";
    
    mysqli_query($conn, $cons_exclui_usuario);

    echo 'ok';

?>