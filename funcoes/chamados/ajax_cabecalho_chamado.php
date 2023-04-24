<?php

    include '../../conexao.php';

    $id_chamado = $_GET['id'];

    // BUSCA INFORMAÇÕES DO CHAMADO PARA ESTRUTURAR O CABEÇALHO
    $cons_informacoes_chamado = "SELECT  ch.DS_CHAMADO,
                                        emp.DS_EMPRESA AS EMPRESA_SOLICITANTE,
                                        (SELECT usu.NM_USUARIO
                                        FROM portal_comunica.CHAMADO ch
                                        INNER JOIN portal_comunica.USUARIO usu
                                            ON usu.CD_USUARIO = ch.CD_USUARIO_CADASTRO
                                        WHERE ch.CD_CHAMADO = $id_chamado) AS SOLICITANTE,
                                        IFNULL((SELECT usu.NM_USUARIO
                                        FROM portal_comunica.CHAMADO ch
                                        INNER JOIN portal_comunica.USUARIO usu
                                            ON usu.CD_USUARIO = ch.CD_USUARIO_RESPONSAVEL
                                        WHERE ch.CD_CHAMADO = $id_chamado), 'SEM RESPONSÁVEL') AS ATENDENTE,
                                        ch.TP_PRIORIDADE AS PRIORIDADE,
                                        (SELECT grp.DS_GRUPO
                                        FROM portal_comunica.CHAMADO ch
                                        INNER JOIN portal_comunica.GRUPO grp
                                            ON ch.CD_GRUPO = grp.CD_GRUPO
                                        WHERE ch.CD_CHAMADO = $id_chamado) AS GRUPO_SOLICITADO,
                                        date_format(ch.DT_PREVISTA, '%d/%m/%Y') AS DATA_PREVISTA,
                                        ch.OBS_MENSAGEM
                                    FROM portal_comunica.CHAMADO ch
                                    INNER JOIN portal_comunica.USUARIO usu
                                    ON usu.CD_USUARIO = ch.CD_USUARIO_CADASTRO
                                    INNER JOIN portal_comunica.EMPRESA emp
                                    ON usu.CD_EMPRESA = emp.CD_EMPRESA
                                    WHERE ch.CD_CHAMADO = $id_chamado";

    $res_informacoes_chamado = mysqli_query($conn, $cons_informacoes_chamado);

    
    $row = mysqli_fetch_row($res_informacoes_chamado);

?>

<div style="width: 100%; height: auto; border: solid 1px #dedfe3; padding: 15px 50px 15px 90px; background-color: #f5f5f5; border-radius: 10px;">

    <div class="row">

        <div class="col-md-12">

            <i class="fa-solid fa-user fa-xl"></i> <h11> <?php echo $row[2]; ?> </h11>

        </div>
        
    </div>

    <div class="div_br"></div>

        <div class="row">

            <div class="col-md-6" style="word-wrap: break-word;">

                <b>Descrição:</b> <br>
                <?php echo $row[0] ?>

            </div>

            <div class="col-md-3">

                <b>Empresa:</b> <br>
                <?php echo $row[1]; ?>

            </div>

            <div class="col-md-3">

                <b>Prioridade:</b> <br>

                <?php if ($row[4] == 'B') {

                    echo 'BAIXA';

                } else if ($row[4] == 'M') {

                    echo 'MÉDIA';

                } else {

                    echo 'ALTA';

                }; ?>

            </div>

        </div>

        <div class="div_br"></div>

        <div class="row">

            <div class="col-md-6" style="word-wrap: break-word;">

                <b>Responsável:</b><br>
                <?php echo $row[3]; ?>

            </div>

            <div class="col-md-3">

                <b>Grupo solicitante:</b></br>
                <?php echo $row[5]; ?>

            </div>

            <div class="col-md-3">

                <b>Data prevista:</b><br>
                <?php echo $row[6]; ?>

            </div>


        </div>

        <div class="div_br"></div>

        <div class="row">

            <div class="col-md-9" style="word-wrap: break-word;">

                <b>Observação:</b>
                <?php echo $row[7]; ?>

            </div>

            <div class="col-md-3">

                <button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Visualizar anexo</button>

            </div>

        </div>

</div>

