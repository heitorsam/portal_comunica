<?php

    include '../../conexao.php';

    $id_empresa = $_POST['id_empresa'];

    // EXCLUI A EMPRESA
    $sql_exclusao_empresa = "DELETE FROM bd_comunic.EMPRESA
                             WHERE CD_EMPRESA = $id_empresa";

    $valida = mysqli_query($conn, $sql_exclusao_empresa);


    if(!$valida){

        echo $sql_exclusao_empresa;

    }else{

        echo 'sucesso';


    }

?>