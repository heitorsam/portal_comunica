<?php

    include '../../conexao.php';

    // QUERY PARA EXCLUIR O USUÁRIO DO GRUPO SELECIONADO
    $cd_grupo = $_POST['id_grupo'];
    $cd_usuario_do_grupo = $_POST['id_usuario'];

    $query_exclui_usuario_grupo = "DELETE FROM portal_comunica.GRUPO_USUARIO
                                   WHERE CD_USUARIO = $cd_usuario_do_grupo
                                         AND CD_GRUPO = $cd_grupo";

    $valida = mysqli_query($conn, $query_exclui_usuario_grupo);

    if(!$valida){
    
        echo $query_exclui_usuario_grupo;

   }else{
    
        echo 'sucesso';

   }


?>