<?php

    session_start();

    include '../../conexao.php';

    $empresa_usuario_logado = $_SESSION['cd_empresa_usuario_logado'];
    $id_grupo = $_GET['idgrupo'];

    /*CONSULTA PARA PEGAR TODOS OS USUÁRIOS QUE PERTENCEM A EMPRESA DO USUÁRIO LOGADO 
    E AINDA NÃO FOI INCLUSO NO GRUPO CLICADO */
    $cons_usuarios_empresa = "SELECT usu.CD_USUARIO, 
                                     usu.NM_USUARIO
                              FROM portal_comunica.USUARIO usu
                              WHERE usu.CD_EMPRESA = $empresa_usuario_logado
                                    AND usu.CD_USUARIO NOT IN (SELECT usu.CD_USUARIO
                                                               FROM portal_comunica.GRUPO_USUARIO grpusu
                                                               INNER JOIN portal_comunica.USUARIO usu
                                                                   ON grpusu.CD_USUARIO = usu.CD_USUARIO
                                                               INNER JOIN portal_comunica.GRUPO grp
                                                                   ON grpusu.CD_GRUPO = grp.CD_GRUPO
                                                               WHERE grp.CD_GRUPO = $id_grupo)";
    
    $res = mysqli_query($conn, $cons_usuarios_empresa);

    while($row = mysqli_fetch_array($res)){

        echo '<option value="'. $row['CD_USUARIO'] .'">' . $row['NM_USUARIO'] . '</option>';

    }

?>
