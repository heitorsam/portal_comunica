<?php

    include '../conexao.php';

    $id_grupo = $_POST['id_empresa_selecionada'];
    $ds_novo_nome_grupo = $_POST['ds_empresa_nova'];    

    //echo $id_grupo;
    echo $ds_novo_nome_grupo;

    $query_editar_grupo = "UPDATE portal_comunica.GRUPO
                            SET DS_GRUPO = '$ds_novo_nome_grupo'
                            WHERE CD_GRUPO = $id_grupo";

    mysqli_query($conn, $query_editar_grupo);

?>