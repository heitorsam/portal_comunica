<?php

    session_start();
    include '../../conexao.php';

    $nome_novo_grupo = $_POST['novo_grupo'];

    $cd_usuario_logado = $_SESSION['cd_usu'];
    $empresa_usuario_logado = $_SESSION['cd_empresa_usuario_logado'];

    $query_inclui_novo_grupo = "INSERT INTO portal_comunica.GRUPO (CD_GRUPO,
                                                                    DS_GRUPO,
                                                                    CD_EMPRESA,
                                                                    CD_USUARIO_CADASTRO,
                                                                    HR_CADASTRO)
                                                                    VALUES (
                                                                    NULL,
                                                                    '$nome_novo_grupo',
                                                                    $empresa_usuario_logado,
                                                                    $cd_usuario_logado,
                                                                    NOW())";

   $valida = mysqli_query($conn, $query_inclui_novo_grupo);

   if(!$valida){
    
        echo $query_inclui_novo_grupo;

   }else{
    
        echo 'sucesso';

   }

?>