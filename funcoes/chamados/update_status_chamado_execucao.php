<?php

    session_start();

    $cd_usuario_logado = $_SESSION['cd_usu'];

    include '../../conexao.php';

    $id_chamado = $_POST['id_chamado'];    
    
    $query_muda_status = "UPDATE bd_comunic.CHAMADO
                          SET TP_STATUS = 'E',
                              CD_USUARIO_RESPONSAVEL = $cd_usuario_logado
                          WHERE CD_CHAMADO = $id_chamado";

    $valida = mysqli_query($conn, $query_muda_status);

    if(!$valida){

        echo 'Erro';
        
    }else{

        echo $id_chamado;
    }   

?>