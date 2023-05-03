<?php

    session_start();

    include '../../conexao.php';

    $ds_empresa_nova = $_POST['ds_nova_empresa'];
    $cd_usu_logado = $_SESSION['cd_usu'];

    $cons_cad_empresa = "INSERT INTO portal_comunica.EMPRESA (
                                    CD_EMPRESA,
                                    DS_EMPRESA,
                                    CD_USUARIO_CADASTRO,
                                    HR_CADASTRO)
                                    VALUES 
                                        (
                                        NULL,
                                        '$ds_empresa_nova',
                                        $cd_usu_logado,
                                        NOW())";
                        
    mysqli_query($conn, $cons_cad_empresa);

?>