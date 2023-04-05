<?php

    include '../conexao.php';

    $id_empresa = $_POST['id_empresa'];

    $sql_exclusao_empresa = "DELETE FROM portal_comunica.EMPRESA
                             WHERE CD_EMPRESA = '$id_empresa'";

    mysqli_query($conn ,$sql_exclusao_empresa);

?>