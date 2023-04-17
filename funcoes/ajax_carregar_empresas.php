<?php

    include '../conexao.php';

    $cons_listar_empresas = "SELECT CD_EMPRESA, DS_EMPRESA FROM portal_comunica.EMPRESA";

    $res = mysqli_query($conn, $cons_listar_empresas);

        echo '<option value="" data-default disabled selected></option>';
        
    while ($row = mysqli_fetch_array($res)){
  
        echo '<option value="'. $row['CD_EMPRESA'] .'">'. $row['DS_EMPRESA'] .'</option>';

    }
    
?>
