<?php

    session_start();

    $var_cd_usu = $_SESSION['cd_usu'];

    include '../../conexao.php';

    echo $cons_listar_empresas = "SELECT emp.CD_EMPRESA, emp.DS_EMPRESA 
                                  FROM portal_comunica.EMPRESA emp
                                  WHERE emp.CD_EMPRESA NOT IN (SELECT usu.CD_EMPRESA 
                                                               FROM portal_comunica.USUARIO usu
                                                               WHERE usu.CD_USUARIO = '$var_cd_usu')
                                  ORDER BY emp.CD_EMPRESA DESC";

    $res = mysqli_query($conn, $cons_listar_empresas);

    echo '<option value="" data-default disabled selected></option>';
    
    while ($row = mysqli_fetch_array($res)){
        
        echo '<option value="'. $row['CD_EMPRESA'] .'">'. $row['DS_EMPRESA'] .'</option>';

    }
    
?>
