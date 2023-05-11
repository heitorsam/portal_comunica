<?php

    session_start();

    include '../../conexao.php';

    $cd_cpf = $_GET['valor_cpf'];

    // CONSULTA DE USUÁRIOS CADASTRADOS
    $consulta = "SELECT 
                 CASE 
                   WHEN COUNT(usu.CD_USUARIO) > 0 THEN 'N'
                   ELSE 'S'
                 END AS SN_AUTORIZA
                 FROM bd_comunic.USUARIO usu
                 WHERE usu.CPF = '$cd_cpf'";

  $res = mysqli_query($conn,$consulta);

  $row = mysqli_fetch_array($res);

  echo $row['SN_AUTORIZA'];

?>