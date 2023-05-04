<?php

    //SESSION
    session_start();

    //USUARIO DA SESSÃO
    $usuario_logado = $_SESSION['nomeusuario'];
    $cd_usu_logado = $_SESSION['cd_usu'];

    //CONEXÃO
    include '../../conexao.php';

    //VERIFICA SE O ARQUIVO FOI ENVIADO
    if(isset($_FILES['foto_usuario']) && $_FILES['foto_usuario']['error'] === UPLOAD_ERR_OK) {

        $conteudo_foto = file_get_contents($_FILES['foto_usuario']['tmp_name']);

    } else {

        $conteudo_foto = null;

    }

    //RECEBENDO VARIAVEIS
    $foto = base64_encode($conteudo_foto);
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nasc = $_POST['data_nasc'];
    $empresa = $_POST['empresa'];
    $senha = $_POST['senha'];
    $tp_usuario = $_POST['tp_usuario'];
    $email = $_POST['email'];
    $foto = $conteudo_foto;

    $cons_insere_usuario = "INSERT INTO portal_comunica.USUARIO (
                                NM_USUARIO,
                                DT_NASCIMENTO,
                                EMAIL,
                                FOTO,
                                CD_EMPRESA,
                                TP_USUARIO,
                                CPF,
                                SENHA,
                                CD_USUARIO_CADASTRO,
                                HR_CADASTRO)
                                VALUES 
                                    (
                                    '$nome',
                                    '$data_nasc',
                                    '$email',
                                    '$foto',
                                    '$empresa',
                                    '$tp_usuario',
                                    '$cpf',
                                    '$senha',
                                    '$cd_usu_logado',
                                    NOW())";

    $valida = mysqli_query($conn, $cons_insere_usuario);

    if(!$valida){
    
        echo $cons_insere_usuario;

    }else{
    
        echo 'sucesso';

    }

?>