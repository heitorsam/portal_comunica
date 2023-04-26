<style>
/* ESTILIZAÇÃO DO SCROLL*/
::-webkit-scrollbar-track {
    background-color: #F4F4F4;
}
::-webkit-scrollbar {
    width: 6px;
    background: #F4F4F4;
}
::-webkit-scrollbar-thumb {
    background: #dad7d7;
}
 
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

<div id="mensagem_acoes"></div>

<h11><i class="fa-solid fa-clipboard-list"></i> Detalhes chamado</h11>
        <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>

<div>
    <!-- ARMAZENA O ID DO CHAMADO -->
    <input style="display: none;" id="id_chamado" type="text" value="<?php echo $id_chamado; ?>">

    <!-- CABEÇALHO -->

    <div style="width: 100%;">

        <div style="width: 30%; float: left;">
    
            <div class="modal-header" style="border: none !important;">

                <h5 class="modal-title" id="exampleModalLabel" style="border: none !important;">

                        <div style="border-radius: 10px; padding: 3px 8px 3px 8px;
                        
                        <?php 

                            if($status_grupo[0] == 'A'){

                                echo 'background-color: rgba(255,131,76,0.3)'; 

                            }else if($status_grupo[0] == 'E'){

                                echo 'background-color: rgba(70,165,212,0.2)'; 

                            }else if($status_grupo[0] == 'C'){

                                echo 'background-color: rgba(59,212,180,0.2)'; 


                            }else{

                                echo 'background-color: white'; 
                            }
                        ?>            
                                    
                        ">

                            <?php echo 'OS: ' . $id_chamado; ?>

                        </div>            
                </h5>

            </div>
            
        </div>

        <div style="width: 70%; float: left;">

            <div class="modal-header" style="border: none !important;">

                <?php 

                    if($status_grupo[0] == 'A'){

                        echo '<div style="width: 100%; text-align: right;">';
    
                            echo '<button onclick="chamar_update_status_execucao()" class="btn btn-primary"><i class="fa-regular fa-thumbs-up"></i> Receber</button>';
                
                        echo '</div>'; 

                    }else if($status_grupo[0] == 'E'){

                        echo '<div style="width: 100%; text-align: right;">';
                
                            echo '<button onclick="chamar_update_status_finalizado()" class="btn btn-primary"><i class="fa-solid fa-check"></i> Finalizar</button>';
                
                        echo '</div>';

                    }else if($status_grupo[0] == 'C'){

                        
                    }else{

                       
                    }
                ?> 

            </div>
     
        </div>

    </div>

    <div style="clear: both;"></div>

    <div id="res_cabecalho_chamado"></div>

    <div class="div_br"></div>

    <?php
        /* VERIFICA SE O STATUS DO CHAMADO SE ENCONTRA COMO ABERTO E SE A CONSULTA QUE VERIFICA SE O GRUPO DO CHAMADO É O MESMO DO USUÁRIO
        LOGADO TROUXE ALGO E CRIA UM BOTÃO PARA RECEBER */
        if ($status_grupo[0] == 'A' && isset($cd_grupo_chamado_usuario[0]) == $status_grupo[1]) {

            //echo '<div style="width: 100%; text-align: center;">';
    
                //echo '<button onclick="chamar_update_status_execucao()" class="botao_home"><i class="fa-brands fa-get-pocket"></i> Receber chamado</button>';
    
            //echo '</div>';

        } else if ($status_grupo[0] != 'A') {

            // 
            if ($status_grupo[0] == 'E' && isset($cd_grupo_chamado_usuario[0]) == $status_grupo[1]) {

                //echo '<div style="width: 100%; text-align: center;">';
        
                    //echo '<button onclick="chamar_update_status_finalizado()" class="botao_home"><i class="fa-brands fa-get-pocket"></i> Finalizar chamado</button>';
        
                //echo '</div>';
    
            }

            // CHAT
            echo '<div id="carrega_mensagens"></div>';

        }

    ?>

    <?php

        if ($status_grupo[0] != 'A' && $status_grupo[0] != 'C') {
            
            // INPUT ARQUIVO FILE
            echo '<div class="row" style="margin-left: 2px; width: 100%;">';

                echo '<div style="width: 30%; padding-right: 10px;">';

                    echo '<div style="border-radius: 5px; height: 30px; float: right;">';
                
                    echo '<label style="color: white;" class="btn btn-primary">';
        
                        echo '<i class="fa fa-upload fa-1x" aria-hidden="true"></i>';                            

                        echo '<input name="arquivo" type="file" id="frm_arquivo_mensagem" style="display: none;">';

                    echo '</label>';
    
                echo '</div>';

                echo '</div>';

                // INPUT ENVIAR
                echo '<center style="width: 70%;">';

                    echo '<input style="float: left;" id="input_msg" onclick="stop_interval()" class="btn_msg" type="text">';

                    echo '<img style="float: left; margin-left: 4px; margin-top: 2px;" class="btn_msg_enviar" src="img/botoes/enviar_msg.png" onclick="enviar_mensagem()">';
                
                echo '</center>';
            
            echo '</div>';

        }

    ?>


</div>   

<?php

    include 'rodape.php';

?>

<script>

    var id_chamado = document.getElementById('id_chamado').value;

    window.onload = function() {

        $('#res_cabecalho_chamado').load('funcoes/chamados/ajax_cabecalho_chamado.php?id=' + id_chamado);
        $('#carrega_mensagens').load('funcoes/chamados/ajax_mensagens.php?id=' + id_chamado);

    }

    // RECARREGA AS MENSAGENS DE 2 EM 2 MINUTOS
    setInterval(() => {
        
        $('#carrega_mensagens').load('funcoes/chamados/ajax_mensagens.php?id=' + id_chamado);

    }, 20000);

    function chamar_update_status_execucao() {

        $.ajax({
            url: "funcoes/chamados/update_status_chamado_execucao.php",
            method: "POST",
            data: {
                id_chamado: id_chamado
            },
            cache: false,
            success(resp) {

                //MENSAGEM            
                var_ds_msg = 'Chamado%20recebido%20com%20sucesso!';
                var_tp_msg = 'alert-success';
    
                $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);                

                setTimeout(function(){
                window.location.reload();
                }, 4000);
                               

            }
        })

    }

    function chamar_update_status_finalizado() {

        $.ajax({
            url: "funcoes/chamados/update_status_chamado_finalizado.php",
            method: "POST",
            data: {
                id_chamado: id_chamado
            },
            cache: false,
            success(resp) {

                //MENSAGEM            
                var_ds_msg = 'Chamado%20finalizado%20com%20sucesso!';
                var_tp_msg = 'alert-success';
    
                $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);


                setTimeout(function(){
                window.location.reload();
                }, 4000);
                                
                
            }
        })

    }

    function enviar_mensagem() {

        var input_mensagem = document.getElementById('input_msg');

        $.ajax({
            url: "funcoes/chamados/inserir_mensagem_chamado.php",
            method: "POST",
            data: {
                id_chamado: id_chamado,
                mensagem: input_mensagem.value
            },
            cache: false,
            success(resp) {

                input_mensagem.value = "";
                $('#carrega_mensagens').load('funcoes/chamados/ajax_mensagens.php?id=' + id_chamado);

            }
        })

    }

</script>

