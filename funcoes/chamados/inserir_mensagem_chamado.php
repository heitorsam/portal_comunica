<?php

    session_start();

    $cd_usuario_logado = $_SESSION['cd_usu'];
    $mensagem = $_POST['mensagem'];

    include '../../conexao.php';

    $id_chamado = $_POST['id_chamado'];

    $insert_mensagem_chamado = "INSERT INTO portal_comunica.ITCHAMADO (CD_CHAMADO,
                                                                    DS_MENSAGEM,
                                                                    ANEXO,
                                                                    EXT,
                                                                    CD_USUARIO_CADASTRO,
                                                                    HR_CADASTRO)
                                                                    VALUES 
                                                                    ($id_chamado,
                                                                    '$mensagem',
                                                                    NULL,
                                                                    NULL,
                                                                    $cd_usuario_logado,
                                                                    NOW())";

    mysqli_query($conn, $insert_mensagem_chamado);

?>