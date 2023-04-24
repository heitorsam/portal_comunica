<style>

    .btn_msg{

        width: 60%;
        border: solid 1px rgba(70,165,212,0.1);
        background-color: rgba(70,165,212,0.15);
        border-radius: 10px;
        padding-left: 10px;
        padding-right: 10px;
    }

    .btn_msg:focus{

        outline: none !important;
        border: solid 1px rgba(70,165,212,0.3); 
        background-color: rgba(70,165,212,0.1);
        padding-left: 10px;
        padding-right: 10px;
        

    }

    .btn_msg_enviar{

        width: 24px;
        height: 24px;
        margin-bottom: 3px;
        
    }

    .btn_msg_enviar:hover{

        opacity: 60%;
        cursor: pointer;

    }

    .mensagem_chat_usu{

        margin: 0 auto;
        padding: 8px;
        float: right;
        text-align: right;
        font-size: 16px;
        background-color: #EAEDED;
        border-radius: 10px;

    }

</style>


<?php

    include 'cabecalho.php';

    include 'conexao.php';

    $id_chamado = $_GET['id'];

    $cd_usuario_logado = $_SESSION['cd_usu'];

    // BUSCA TODAS AS MENSAGENS DO CHAMADO
    $cons_mensagens_chamado = "SELECT itch.DS_MENSAGEM,
                                      itch.CD_USUARIO_CADASTRO AS USUARIO_CADASTRO_MENSAGEM,
                                      ch.CD_USUARIO_CADASTRO AS USUARIO_CADASTRO_CHAMADO,
                                      ch.TP_STATUS
                                    FROM portal_comunica.CHAMADO ch
                                    INNER JOIN portal_comunica.ITCHAMADO itch
                                    ON ch.CD_CHAMADO = itch.CD_CHAMADO
                                    WHERE ch.CD_CHAMADO = $id_chamado";

    $res = mysqli_query($conn, $cons_mensagens_chamado);

    // PEGA O TP STATUS DO CHAMADO E O GRUPO PARA QUAL FOI SOLICITADO
    $cons_tp_status_grupo = "SELECT TP_STATUS, 
                              CD_GRUPO
                            FROM portal_comunica.CHAMADO
                            WHERE CD_CHAMADO = $id_chamado";

    $res_status_grupo = mysqli_query($conn, $cons_tp_status_grupo);

    $status_grupo = mysqli_fetch_row($res_status_grupo);

    // IDENTIFICAR SE O USUÁRIO PERTENCE AO GRUPO SOLICITADO DO CHAMADO
    $cons_grupo_chamado_usuario = "SELECT grupo_chamado.CD_GRUPO
                                    FROM (SELECT CD_GRUPO
                                        FROM portal_comunica.CHAMADO
                                        WHERE CD_CHAMADO = $id_chamado) AS grupo_chamado
                                    WHERE grupo_chamado.CD_GRUPO IN (SELECT CD_GRUPO
                                                                    FROM portal_comunica.GRUPO_USUARIO
                                                                    WHERE CD_USUARIO = $cd_usuario_logado)";
    
    $res_cons_grupo = mysqli_query($conn, $cons_grupo_chamado_usuario);

    $cd_grupo_chamado_usuario = mysqli_fetch_row($res_cons_grupo);

?>

<div>
    <!-- ARMAZENA O ID DO CHAMADO -->
    <input style="display: none;" id="id_chamado" type="text" value="<?php echo $id_chamado; ?>">

    <!-- CABEÇALHO -->
    <div class="modal-header" style="border: none !important;">

        <h5 class="modal-title" id="exampleModalLabel" style="border: none !important;">

            <div style="background-color: #ffd9ac; border-radius: 10px; padding: 3px;">

                <?php echo 'OS: ' . $id_chamado; ?>

            </div>
        
        </h5>

    </div>

    <div id="res_cabecalho_chamado"></div>

    <div class="div_br"></div>

    <?php
        /* VERIFICA SE O STATUS DO CHAMADO SE ENCONTRA COMO ABERTO E SE A CONSULTA QUE VERIFICA SE O GRUPO DO CHAMADO É O MESMO DO USUÁRIO
        LOGADO TROUXE ALGO E CRIA UM BOTÃO PARA RECEBER */
        if ($status_grupo[0] == 'A' && isset($cd_grupo_chamado_usuario[0]) == $status_grupo[1]) {

            echo '<div style="width: 100%; text-align: center;">';
    
                echo '<button class="botao_home"><i class="fa-brands fa-get-pocket"></i> Receber chamado</button>';
    
            echo '</div>';

        } else if ($status_grupo[0] != 'A') {

            // CHAT
            echo '<div class="modal-footer" style="border: none !important; padding: 0px;">';
        
                echo '<div class="div_br"> </div>';
        
                echo '<div style="width: 100%; margin: 0 auto;">';
        
                    // LINHA HORIZONTAL
                    echo '<div style="margin: 0 auto; width: 98%; height: 20px; clear: both; border-bottom: 1px solid #dee2e6; margin-top: -35px !important; margin-bottom: 10px; "></div><div style="clear: both;"> </div><div class="div_br"></div>';       

                    while ($row = mysqli_fetch_array($res)) {
        
                        if ($row['USUARIO_CADASTRO_MENSAGEM'] == $row['USUARIO_CADASTRO_CHAMADO']) {
        
                            // CABEÇALHO DA MENSAGEM
                            echo '<div style="clear: both; width: 80%; height: 30px; font-size: 14px; text-align: center;
                            margin: 0 auto;"> DATA HORA - NOME COMPLETO <div style="background-color: #ffd9ac; width: 45%; margin: 0 auto; border-radius: 5px;"> SOLICITANTE </div></div>';
                
                            echo '<div class="div_br"> </div>';
                            echo '<div class="div_br"> </div>';
                
                            // MENSAGEM
                            echo '<img alt="teste_img" class="foto_usu" style="width:50px; height: 50px; float:right; margin-left: 10px; border-radius: 30px; border-color: #d6eaf8 !important; border: solid 2px; opacity: 30%;" src="img/outros/usuario.png">';
                            echo '<div class="mensagem_chat_usu">' . $row['DS_MENSAGEM'] . '</div>';     
        
                        } else {
        
                            echo '<div style="clear: both; width: 80%; height: 30px; font-size: 14px; text-align: center;
                            margin: 0 auto;"> DATA HORA - NOME COMPLETO <div style="background-color: #ffd9ac; width: 45%; margin: 0 auto; border-radius: 5px;"> ATENDENTE </div></div>';
                
                            echo '<div class="div_br"> </div>';
                            echo '<div class="div_br"> </div>';
                
                            // MENSAGEM
                            echo '<img alt="teste_img" class="foto_usu" style="width:50px; height: 50px; float:left; margin-left: 10px; border-radius: 30px; border-color: #d6eaf8 !important; border: solid 2px; opacity: 30%;" src="img/outros/usuario.png">';
                            echo '<div style="float:left;" class="mensagem_chat_usu">' . $row['DS_MENSAGEM'] . '</div>';   
        
                        }
        
                        // LINHA HORIZONTAL
                        echo '<div style="margin: 0 auto; width: 98%; height: 20px; clear: both; border-bottom: 1px solid #dee2e6; margin-top: -35px !important; margin-bottom: 10px; "></div><div style="clear: both;"> </div><div class="div_br"></div>';  
        
                    }
        
                echo '</div>';
        
            echo '</div>';

        }

    ?>

    <!-- INPUT ENVIAR -->
    <?php

        if ($status_grupo[0] != 'A' && $status_grupo[0] != 'C') {

            echo '<center>';

                echo '<input id="input_msg" onclick="stop_interval()" class="btn_msg" type="text">';

                echo '<img class="btn_msg_enviar" src="img/botoes/enviar_msg.png" onclick="cad_msg(<?php echo $var_cd_os; ?>)">';
            
            echo '</center>';

        }

    ?>


</div>   

<?php

    include 'rodape.php';

?>

<script>

    window.onload = function ajax_tabela_cabecalho_chamado() {

        var id_chamado = document.getElementById('id_chamado').value;

        $('#res_cabecalho_chamado').load('funcoes/chamados/ajax_cabecalho_chamado.php?id=' + id_chamado);

    }

</script>

