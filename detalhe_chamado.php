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

    //APENAS GRUPOS PERTENCENTES
    include 'acesso_restrito_grupos.php';

    // PEGA O TP STATUS DO CHAMADO E O GRUPO PARA QUAL FOI SOLICITADO
    $cons_tp_status_grupo = "SELECT TP_STATUS, 
                              CD_GRUPO,
                              TP_PRIORIDADE
                            FROM bd_comunic.CHAMADO
                            WHERE CD_CHAMADO = $id_chamado";

    $res_status_grupo = mysqli_query($conn, $cons_tp_status_grupo);

    $status_grupo = mysqli_fetch_row($res_status_grupo);

    // IDENTIFICAR SE O USUÁRIO PERTENCE AO GRUPO SOLICITADO DO CHAMADO
    $cons_grupo_chamado_usuario = "SELECT grupo_chamado.CD_GRUPO
                                    FROM (SELECT CD_GRUPO
                                        FROM bd_comunic.CHAMADO
                                        WHERE CD_CHAMADO = $id_chamado) AS grupo_chamado
                                    WHERE grupo_chamado.CD_GRUPO IN (SELECT CD_GRUPO
                                                                    FROM bd_comunic.GRUPO_USUARIO
                                                                    WHERE CD_USUARIO = $cd_usuario_logado)";
    
    $res_cons_grupo = mysqli_query($conn, $cons_grupo_chamado_usuario);

    $cd_grupo_chamado_usuario = mysqli_fetch_row($res_cons_grupo);

?>

<div id="mensagem_acoes"></div>

<h11><i class="fa-solid fa-clipboard-list"></i> Detalhes chamado</h11>
        <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>

<div>
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

                            <?php 

                                if($status_grupo[2] == 'B'){ $var_prioridade = '<i class="fa-solid fa-caret-down" style="color: green"></i>'; }                    
                                if($status_grupo[2] == 'M'){ $var_prioridade = '<i class="fa-solid fa-grip-lines" style="color: orange;"></i>'; }                    
                                if($status_grupo[2] == 'A'){ $var_prioridade = '<i class="fa-solid fa-caret-up" style="color: red"></i>'; }                                      
                            
                                echo $var_prioridade . ' OS: ' . $id_chamado; 
                                
                            ?>

                        </div>            
                </h5>

            </div>
            
        </div>

        <div style="width: 70%; float: left;">

            <div class="modal-header" style="border: none !important;">

                <?php 

                    //echo 'status: ' . $status_grupo[0] . '</br>'; 
                    //echo 'grupo usuario: ' . $cd_grupo_chamado_usuario[0] . '</br>'; 
                    //echo 'grupo chamado: ' . $status_grupo[1] . '</br>'; 

                    if($status_grupo[0] == 'A' && @$cd_grupo_chamado_usuario[0] == $status_grupo[1]){

                        echo '<div style="width: 100%; text-align: right;">';
    
                            echo '<button onclick="chamar_update_status_execucao()" class="btn btn-primary"><i class="fa-regular fa-thumbs-up"></i> Receber</button>';
                
                        echo '</div>'; 

                    }else if($status_grupo[0] == 'E' && @$cd_grupo_chamado_usuario[0] == $status_grupo[1]){

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

    <form method="POST" id="frm_mensagem" enctype='multipart/form-data'>

        <!-- ARMAZENA O ID DO CHAMADO -->
        <input style="display: none;" name="id_chamado" id="id_chamado" type="text" value="<?php echo $id_chamado; ?>">

    <?php

        if ($status_grupo[0] != 'A' && $status_grupo[0] != 'C') {
            
            // INPUT ARQUIVO FILE
            echo '<div class="row" style="margin-left: 2px; width: 100%;">';

                echo '<div style="width: 30%; padding-right: 10px;">';

                    echo '<div style="border-radius: 5px; height: 30px; float: right;">';
                
                    echo '<label style="color: white;" class="btn btn-primary">';
        
                        echo '<i class="fa fa-upload fa-1x" aria-hidden="true"></i>';                            

                        echo '<input name="arquivo_mensagem" type="file" id="frm_arquivo_mensagem" style="display: none;">';

                    echo '</label>';
    
                echo '</div>';

                echo '</div>';

                // INPUT ENVIAR
                echo '<center style="width: 70%;">';

                    echo '<input name="mensagem" style="float: left;" id="input_msg" onclick="stop_interval()" class="btn_msg" type="text">';

                    echo '<img style="float: left; margin-left: 4px; margin-top: 2px;" class="btn_msg_enviar" src="img/botoes/enviar_msg.png" onclick="enviar_mensagem()">';
                
                echo '</center>';
            
            echo '</div>';

        }

    ?>

    </form>


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
            success(res) {

                if (res != 'Erro') {

                    ajax_envia_email(res,'Recebimento de Chamado','Seu chamado foi recebido por um colaborador.','a');
                            
                    //MENSAGEM            
                    var_ds_msg = 'Enviando%20e-mail!';
                    var_tp_msg = 'alert-primary';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 


                    //AGUARDA 3 SEGUNDOS ANTES DE EXECUTAR OS COMANDOS ABAIXO
                    setTimeout(function(){     

                        //MENSAGEM            
                        var_ds_msg = 'Chamado%20recebido%20com%20sucesso!';
                        var_tp_msg = 'alert-success';
            
                        $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);                

                        setTimeout(function(){
                        window.location.reload();
                        }, 4000);

                    }, 3000);        
                    
                } else {

                    //MENSAGEM            
                    var_ds_msg = 'Erro%20ao%20abrir%20chamado!';
                    var_tp_msg = 'alert-danger';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

                }

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
            success(res) {

                if (res != 'Erro') {

                    ajax_envia_email(res,'Chamado Encerrado','Seu chamado foi finalizado por um colaborador.','a');
                            
                    //MENSAGEM            
                    var_ds_msg = 'Enviando%20e-mail!';
                    var_tp_msg = 'alert-primary';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 


                    //AGUARDA 3 SEGUNDOS ANTES DE EXECUTAR OS COMANDOS ABAIXO
                    setTimeout(function(){     

                        //MENSAGEM            
                        var_ds_msg = 'Chamado%20finalizado%20com%20sucesso!';
                        var_tp_msg = 'alert-success';
 
                        $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);                

                        setTimeout(function(){
                        window.location.reload();
                        }, 4000);

                    }, 3000);        

                } else {

                    //MENSAGEM            
                    var_ds_msg = 'Erro%20ao%20abrir%20chamado!';
                    var_tp_msg = 'alert-danger';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

                }                                    
            }
        })

    }

    function enviar_mensagem() {

        var form = document.getElementById('frm_mensagem');
        var formData = new FormData(form);

        var input_mensagem = document.getElementById('input_msg');

        $.ajax({
            url: "funcoes/chamados/inserir_mensagem_chamado.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success(res) {

                console.log(res);

                if(res != 'Erro'){

                    ajax_envia_email(id_chamado,'Nova mensagem','Você recebeu uma nova mensagem no seu chamado.',res);

                }                

                input_mensagem.value = "";
                document.getElementById("frm_arquivo_mensagem").value = "";
                $('#carrega_mensagens').load('funcoes/chamados/ajax_mensagens.php?id=' + id_chamado);

            }
        })

    }

</script>

