<?php

    //SESSION
    session_start();

    //USUARIO DA SESSÃO
    $usuario_logado = $_SESSION['nomeusuario'];
    $cd_usu_logado = $_SESSION['cd_usu'];

    //CONEXÃO
    include '../conexao.php';

    //VERIFICA SE O ARQUIVO FOI ENVIADO
    if(isset($_FILES['foto_usuario']) && $_FILES['foto_usuario']['error'] === UPLOAD_ERR_OK) {

        $conteudo_foto = file_get_contents($_FILES['foto_usuario']['tmp_name']);
    
    } else {
    
        $conteudo_foto = null;
    
    }

    //VARIAVEIS DA MODAL DE EDIÇÃO
    $nm_usuario = $_POST['nome'];
    $senha = $_POST['senha'];
    $empresa = $_POST['empresa'];
    $tp_usuario = $_POST['tp_usuario'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $foto = base64_encode($conteudo_foto);
    $id_usuario = $_POST['id_usuario'];
    
    $cons_edita_usuario = "UPDATE portal_comunica.USUARIO usu
                            SET usu.NM_USUARIO = '$nm_usuario',
                                usu.EMAIL = '$email',
                                usu.FOTO = '$foto',
                                usu.CD_EMPRESA = $empresa,
                                usu.TP_USUARIO = '$tp_usuario',
                                usu.CPF = '$cpf',
                                usu.SENHA = '$senha',
                                usu.CD_USUARIO_ULT_ALT = $cd_usu_logado,
                                usu.HR_ULT_ALT = NOW()
                            WHERE usu.CD_USUARIO = $id_usuario";
    
    mysqli_query($conn, $cons_edita_usuario);

    // VERIFICA SE O USUÁRIO DE EDIÇÃO É O USUÁRIO EM QUE ESTÁ LOGADO PARA ALTERAR OS DADOS NA SESSÃO
    if ($id_usuario == $cd_usu_logado) {

        $_SESSION['nomeusuario'] = $nm_usuario;
        $_SESSION['cd_empresa_usuario_logado'] = $empresa;

    }
    
    
?>