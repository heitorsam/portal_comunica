<?php

    include '../conexao.php';

    $id_usuario = $_POST['id_usuario'];

    $sql_exclusao_usuario = "DELETE FROM portal_comunica.USUARIO
                             WHERE CD_USUARIO = '$id_usuario'";

    mysqli_query($conn ,$sql_exclusao_usuario);

?>