<?php

    include '../../conexao.php';

    $id_grupo = $_POST['id_empresa_selecionada'];
    $ds_novo_nome_grupo = $_POST['ds_empresa_nova'];    

    //echo $id_grupo;
    $ds_novo_nome_grupo;

    $query_editar_grupo = "UPDATE bd_comunic.GRUPO
                           SET DS_GRUPO = '$ds_novo_nome_grupo'
                           WHERE CD_GRUPO = $id_grupo";

    $valida = mysqli_query($conn, $query_editar_grupo);

    if(!$valida){
    
        echo $query_editar_grupo;

   }else{
    
        echo 'sucesso';

   }


?>