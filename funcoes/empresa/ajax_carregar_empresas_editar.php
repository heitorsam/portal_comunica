<?php

    session_start();

    $var_cd_usu_edicao = $_GET['cd_usu_edicao'];

    include '../../conexao.php';

    echo $cons_listar_empresas = "SELECT emp.CD_EMPRESA, emp.DS_EMPRESA 
                                  FROM bd_comunic.EMPRESA emp
                                  WHERE emp.CD_EMPRESA IN (SELECT usu.CD_EMPRESA FROM bd_comunic.USUARIO usu WHERE usu.CD_USUARIO = '$var_cd_usu_edicao')
                                  
                                  UNION ALL
                                  
                                  SELECT res.*
                                  FROM(SELECT emp.CD_EMPRESA, emp.DS_EMPRESA 
                                       FROM bd_comunic.EMPRESA emp
                                       WHERE emp.CD_EMPRESA NOT IN (SELECT usu.CD_EMPRESA FROM bd_comunic.USUARIO usu WHERE usu.CD_USUARIO = '$var_cd_usu_edicao')
                                       ORDER BY emp.DS_EMPRESA ASC) res
                                  ";

    $res = mysqli_query($conn, $cons_listar_empresas);
        
    while ($row = mysqli_fetch_array($res)){
  
        echo '<option value="'. $row['CD_EMPRESA'] .'">'. $row['DS_EMPRESA'] .'</option>';

    }
    
?>
