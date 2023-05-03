<?php

    include '../../conexao.php';

    $id_empresa = $_POST['id'];

    $cons_verifica_qtdd_usuarios_empresa = "SELECT *
                                            FROM portal_comunica.USUARIO
                                            WHERE CD_EMPRESA = $id_empresa";

    $res = mysqli_query($conn, $cons_verifica_qtdd_usuarios_empresa);

    $quantidade = mysqli_num_rows($res);

    echo $quantidade;

?>