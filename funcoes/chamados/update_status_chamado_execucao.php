<?php

    session_start();

    $cd_usuario_logado = $_SESSION['cd_usu'];

    include '../../conexao.php';

    $id_chamado = $_POST['id_chamado'];    
    
    $query_muda_status = "UPDATE portal_comunica.CHAMADO
                          SET TP_STATUS = 'E',
                              CD_USUARIO_RESPONSAVEL = $cd_usuario_logado
                          WHERE CD_CHAMADO = $id_chamado";

    mysqli_query($conn, $query_muda_status);

?>