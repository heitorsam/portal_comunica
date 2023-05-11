<?php

    session_start();

    include '../../conexao.php';

    $cd_usu = $_GET['var_cd_usu'];
    $cd_usu_logado = $_SESSION['cd_usu'];

    // CONSULTA DE USUÁRIOS CADASTRADOS
    $consulta = "SELECT DISTINCT usu.CD_USUARIO, usu.NM_USUARIO
                 FROM bd_comunic.GRUPO_USUARIO gu
                 INNER JOIN bd_comunic.USUARIO usu
                   ON usu.CD_USUARIO = gu.CD_USUARIO
                 WHERE gu.CD_GRUPO IN (SELECT grpusu.CD_GRUPO FROM bd_comunic.GRUPO_USUARIO grpusu WHERE grpusu.CD_USUARIO = $cd_usu_logado)
                 AND gu.CD_USUARIO = $cd_usu

                 UNION ALL 

                 SELECT res.* 
                 FROM (
                 SELECT DISTINCT usu.CD_USUARIO, usu.NM_USUARIO
                 FROM bd_comunic.GRUPO_USUARIO gu
                 INNER JOIN bd_comunic.USUARIO usu
                   ON usu.CD_USUARIO = gu.CD_USUARIO
                 WHERE gu.CD_GRUPO IN (SELECT grpusu.CD_GRUPO FROM bd_comunic.GRUPO_USUARIO grpusu WHERE grpusu.CD_USUARIO = $cd_usu_logado)
                 AND gu.CD_USUARIO <> $cd_usu
                 ORDER BY usu.NM_USUARIO ASC
                 ) res
                 
                 ";

    // EXECUTA A CONSULTA E ARMAZENA NA VARIAVEL O RESULTADO
    $res = mysqli_query($conn,$consulta);

    // PERCORRE AS LINHAS DE TODOS OS USUÁRIOS CADASTRADOS
    while ($row = mysqli_fetch_array($res)) {

            echo '<option value="'. $row['CD_USUARIO'] .'">' . $row['NM_USUARIO']. '</option>';         
    }

?>