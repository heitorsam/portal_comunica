<?php

    //SESSION
    session_start();

    //USUARIO DA SESSÃO
    $usuario_logado = $_SESSION['nomeusuario'];
    $cd_usu_logado = $_SESSION['cd_usu'];

    //CONEXÃO
    include '../../conexao.php';

    //VARIAVEL DA MODAL DE EDIÇÃO
    $id_empresa = $_POST['id_empresa'];
    $ds_empresa = $_POST['ds_empresa'];
    
    $cons_edita_empresa = "UPDATE bd_comunic.EMPRESA emp
                            SET emp.DS_EMPRESA = '$ds_empresa',
                                emp.CD_USUARIO_ULT_ALT = '$cd_usu_logado',
                                emp.HR_ULT_ALT = NOW()
                            WHERE emp.CD_EMPRESA = $id_empresa";
    
    $valida = mysqli_query($conn, $cons_edita_empresa);

    if(!$valida){

        echo $cons_edita_empresa;

    }else{

        echo 'sucesso';


    }

    

?>