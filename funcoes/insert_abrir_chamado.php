<?php

    session_start();

    $cd_usuario_logado = $_SESSION['cd_usu'];

    include '../conexao.php';
    
    // $destino_foto = null;
    // $extensao = null;
    $descricao = $_POST['descricao'];
    $empresa = $_POST['empresa'];
    $grupo = $_POST['grupo'];
    $prioridade = $_POST['prioridade'];
    $data_prevista = $_POST['data_prevista'];
    $observacao = $_POST['observacao'];

    echo $query_insere_chamado = "INSERT INTO portal_comunica.CHAMADO (
                                                    CD_CHAMADO,
                                                    DS_CHAMADO,
                                                    CD_EMPRESA,
                                                    CD_GRUPO,
                                                    TP_PRIORIDADE,
                                                    DT_PREVISTA,
                                                    TP_STATUS,
                                                    OBS_MENSAGEM,
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
                                                    '$observacao',
                                                    $cd_usuario_logado,
                                                    NOW())";
    
    mysqli_query($conn, $query_insere_chamado);

    // PEGAR O CD DO CHAMADO GERADO PARA INSERIR NO ITCHAMADO
/*     $cons_cd_chamado = "SELECT CD_CHAMADO
                        FROM portal_comunica.CHAMADO
                        WHERE DS_CHAMADO = '$descricao'
                            AND CD_EMPRESA = $empresa
                            AND CD_GRUPO = $grupo
                            AND TP_PRIORIDADE = '$prioridade'
                            AND DT_PREVISTA = '$data_prevista'
                            AND TP_STATUS = 'A'
                            AND CD_USUARIO_CADASTRO = $cd_usuario_logado";

    $res = mysqli_query($conn, $cons_cd_chamado);

    $row_cd_chamado = mysqli_fetch_row($res);

    $cd_chamado = $row_cd_chamado[0];

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
                                                    $cd_chamado,
                                                    '$observacao',
                                                    '$destino_foto',
                                                    '$extensao',
                                                    $cd_usuario_logado,
                                                    NOW())";

    mysqli_query($conn, $query_insere_itchamado); */

?>