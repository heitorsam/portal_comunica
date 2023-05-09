<?php

    include 'conexao_ftp.php';

    $var_diretorio = $_GET['diretorio'];
    //echo $var_diretorio;

    $size = ftp_size($conexao_ftp, $var_diretorio);
    
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . basename($var_diretorio));
    header("Content-Length: $size"); 

    ftp_get($conexao_ftp, "php://output", $var_diretorio, FTP_BINARY);   

?>