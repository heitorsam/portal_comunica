<?php

    session_start();

    $var_cd_usu = $_SESSION['cd_usu'];

    include '../../conexao.php';

    echo $cons_listar_empresas = "SELECT emp.CD_EMPRESA, emp.DS_EMPRESA 
                                  FROM portal_comunica.EMPRESA emp
                                  ORDER BY emp.CD_EMPRESA DESC";

    $res = mysqli_query($conn, $cons_listar_empresas);
        
    while ($row = mysqli_fetch_array($res)){
  
        echo '<option value="'. $row['CD_EMPRESA'] .'">'. $row['DS_EMPRESA'] .'</option>';

    }
    
?>
