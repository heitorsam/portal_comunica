<?php

    include '../../conexao.php';

    $id_grupo = $_POST['id_grupo'];

    // DELETA TODOS OS USUARIOS DA TABELA GRUPO USUARIOS
    $query_deleta_usuarios_grupo = "DELETE FROM bd_comunic.GRUPO_USUARIO
                                    WHERE CD_GRUPO = $id_grupo";

    $valida = mysqli_query($conn, $query_deleta_usuarios_grupo);

    if(!$valida){
    
        echo $query_deleta_usuarios_grupo;

   }else{
    
         // DELETA O GRUPO
        $query_deleta_grupo = "DELETE FROM bd_comunic.GRUPO
        WHERE CD_GRUPO = $id_grupo";

        $valida = mysqli_query($conn, $query_deleta_grupo);

        if(!$valida){

            echo $query_deleta_grupo;

        }else{

            echo 'sucesso';


        }
   
   }

?>