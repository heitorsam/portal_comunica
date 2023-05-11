<?php

    include '../../conexao.php';

    $id_usuario = $_POST['id_usuario'];

    $sql_exclusao_usuario = "DELETE FROM bd_comunic.USUARIO
                             WHERE CD_USUARIO = '$id_usuario'";

    $valida = mysqli_query($conn ,$sql_exclusao_usuario);

    if(!$valida){
    
        echo $sql_exclusao_usuario;

    }else{
    
        echo 'sucesso';

    }

?>