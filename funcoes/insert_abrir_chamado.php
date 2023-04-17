<?php

    session_start();

    $cd_usuario_logado = $_SESSION['cd_usu'];

    include '../conexao.php';
    
    $destino_foto = null;
    $extensao = null;
    $descricao = $_POST['descricao'];
    $empresa = $_POST['empresa'];
    $grupo = $_POST['grupo'];
    $prioridade = $_POST['prioridade'];
    $data_prevista = $_POST['data_prevista'];
    $observacao = $_POST['observacao'];

    $query_insere_chamado = "INSERT INTO portal_comunica.CHAMADO (
                                                    CD_CHAMADO,
                                                    DS_CHAMADO,
                                                    CD_EMPRESA,
                                                    CD_GRUPO,
                                                    TP_PRIORIDADE,
                                                    DT_PREVISTA,
                                                    TP_STATUS,
                                                    CD_USUARIO_CADASTRO,
                                                    HR_CADASTRO)
                                                    VALUES (
                                                    NULL,
                                                    '$descricao',
                                                    $empresa,
                                                    '$grupo',
                                                    '$prioridade',
                                                    '$data_prevista',
                                                    'A',
                                                    $cd_usuario_logado,
                                                    NOW())";
    
    mysqli_query($conn, $query_insere_chamado);

    $query_insere_itchamado = "INSERT INTO portal_comunica.ITCHAMADO (
                                                    CD_ITCHAMADO,
                                                    CD_CHAMADO,
                                                    DS_MENSAGEM,
                                                    ANEXO,
                                                    EXT,
                                                    CD_USUARIO_CADASTRO,
                                                    HR_CADASTRO)
                                                    VALUES (
                                                    NULL,
                                                    NULL,
                                                    '$observacao',
                                                    '$destino_foto',
                                                    '$extensao',
                                                    $cd_usuario_logado,
                                                    NOW())";

    mysqli_query($conn, $query_insere_itchamado);

?>