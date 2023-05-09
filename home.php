<?php

    include 'cabecalho.php';

?>

<input id="inpt_pag_atual" hidden>

<input id="input_usu_logado" value="<?php echo $_SESSION['cd_usu']; ?>" hidden>
 
    <h11><i class="fa-solid fa-list efeito-zoom" aria-hidden="true"></i> Home</h11>
    <div class='espaco_pequeno'></div>
    
    <!-- <h27><a onclick="alert('teste')" style="color: #555555; text-decoration: none; cursor: pointer;"><i class="fa-solid fa-filter"></i></a></h27> -->
    <!--</br> </br> <button class="btn btn-primary" 
    onclick="ajax_envia_email('56','Abertura de Chamado','Foi aberto um novo chamado ao seu grupo pertencente.','r')">
    <i class="fa-regular fa-envelope"></i> Teste E-mail</button> </br>-->

    <div class="row">

        <div class="col-10 col-md-3" style="text-align: left; background-color: rgba(0,0,0,0) !important; padding: 10px;">

            Período:</br>            
            <input onchange="chama_paginas('x')" id="periodo" class="form form-control" type="month">       

        </div>

        <div class="col-10 col-md-4" style="text-align: left; background-color: rgba(0,0,0,0) !important; padding: 10px;">

            Prestador:</br>            
            <select class="form-control" id="sel_prestador" onchange="ajax_lista_prestador_grupo('filtro')">
            </select>    

        </div>

        <div class="col-4 col-md-1" style="text-align: left; background-color: rgba(0,0,0,0) !important; padding: 10px;">

            OS:</br>            
            <input onkeyup="chama_paginas('x')" class="form-control" id="txt_os">

        </div>

    </div>

    <div class="div_br"></div>
    <div class="row justify-content-center" style="margin-bottom: 10px;">

        <div class="col-4" style="text-align: center; background-color: rgba(1,1,1,0) !important; padding: 0px !important;">

            <h11 id="solic" onclick="chama_paginas('1'), ajax_style('1')" style="cursor: pointer;"><i class="fa-solid fa-phone-volume"></i> Solicitações</h11>

        </div>

        <div class="col-4" style="text-align: center; background-color: rgba(1,1,1,0) !important; padding: 0px !important;">

            <h11  id="chamados" onclick="chama_paginas('2'), ajax_style('2')" style="cursor: pointer;"><i class="fa-solid fa-headset"></i> Meus chamados</h11>

        </div>

        <div class="col-4" style="text-align: center; background-color: rgba(1,1,1,0) !important; padding: 0px !important;">

            <h11 id="dash" onclick="chama_paginas('3'), ajax_style('3')" style="cursor: pointer;"><i class="fa-solid fa-chart-line"></i> Dashboard</h11>

        </div>

    </div>

    <div class="div_br"></div>

    <div id="resultados_ajax"></div>
    
<?php

    include 'rodape.php';

?>

<script> 

    //VERIFICANDO SE EXISTE SESSAO
    var js_sessao_periodo = sessionStorage.getItem("periodo");
    var js_sessao_cd_usu_sel = sessionStorage.getItem("cd_usu_sel");
    var js_pg_at = sessionStorage.getItem("sessao_ult_pg"); 

    if(js_sessao_periodo == null || js_sessao_periodo == ''){

        js_agora = new Date();

        if((js_agora.getMonth()+1) <= 9){

            js_agora_format = js_agora.getFullYear() + "-0" + (js_agora.getMonth()+1);

        }else{

            js_agora_format = js_agora.getFullYear() + "-" + js_agora.getMonth();
        }
        
        document.getElementById('periodo').value = js_agora_format;
        periodo = sessionStorage.setItem("periodo", js_agora_format);

        ajax_lista_prestador_grupo('acesso');
        ajax_style('1');

    }else{

        document.getElementById('periodo').value = js_sessao_periodo;
        $('#sel_prestador').load('funcoes/usuario/ajax_lista_usuario_grupo_filtro.php?var_cd_usu='+js_sessao_cd_usu_sel);

        ajax_style(js_pg_at);
        chama_paginas(js_pg_at);

    }
    
    function ajax_lista_prestador_grupo(var_acao){

        //TRABALHANDO AS SESSOES
        var js_sessao_cd_usu = sessionStorage.getItem("cd_usu_sel");

        var js_sessao_cd_usu_tamanho = !!js_sessao_cd_usu?.length;

        //alert(js_sessao_cd_usu_tamanho);

        if(var_acao == 'acesso'){            

            if(js_sessao_cd_usu_tamanho == false){

                if(//js_sessao_cd_usu.lenght == 'undefined' || js_sessao_cd_usu.lenght == undefined || 
                js_sessao_cd_usu == 'undefined' || js_sessao_cd_usu == undefined 
                || js_sessao_cd_usu == 'null' || js_sessao_cd_usu == null){

                    var js_var_cd_usu = document.getElementById('input_usu_logado').value;
                    sessionStorage.setItem("cd_usu_sel", js_var_cd_usu);             
                    //alert('1');
                
                }else{

                    var js_var_cd_usu = js_sessao_cd_usu;
                    //alert('2');
                }     
            
            }else{

                if(js_sessao_cd_usu.lenght == 'undefined' || js_sessao_cd_usu.lenght == undefined || 
                js_sessao_cd_usu == 'undefined' || js_sessao_cd_usu == undefined 
                || js_sessao_cd_usu == 'null' || js_sessao_cd_usu == null){

                    var js_var_cd_usu = document.getElementById('input_usu_logado').value;
                    sessionStorage.setItem("cd_usu_sel", js_var_cd_usu);             
                    //alert('3');
                
                }else{

                    var js_var_cd_usu = js_sessao_cd_usu;
                    //alert('4');
                }     
            }

            chama_paginas('prest_inicio');

        }

        if(var_acao == 'filtro'){

            var js_var_cd_usu = document.getElementById('sel_prestador').value;

            //TRABALHANDO AS SESSOES
            sessionStorage.setItem("cd_usu_sel", js_var_cd_usu);

            //alert('valor filtro ' + js_var_cd_usu);

            chama_paginas('x');

        }     

        //alert(js_var_cd_usu);

        $('#sel_prestador').load('funcoes/usuario/ajax_lista_usuario_grupo_filtro.php?var_cd_usu='+js_var_cd_usu);

        

    }

    // APLICAR EFEITO AZUL E MANTER APÓS CLICAR
    function ajax_style(btn){

        if (btn == '1') {

            document.getElementById('solic').setAttribute("style", "border-bottom: solid 2px #17a2b8; cursor: pointer;");

            document.getElementById('chamados').removeAttribute("style");
            document.getElementById('dash').removeAttribute("style");

            // ADICIONA O CURSOR APÓS RETIRAR O STYLE
            document.getElementById('chamados').setAttribute("style", "cursor: pointer;");
            document.getElementById('dash').setAttribute("style", "cursor: pointer;");

        } else if (btn == '2') {

            document.getElementById('chamados').setAttribute("style", "border-bottom: solid 2px #17a2b8; cursor: pointer;");

            document.getElementById('solic').removeAttribute("style");
            document.getElementById('dash').removeAttribute("style");

            // ADICIONA O CURSOR APÓS RETIRAR O STYLE
            document.getElementById('solic').setAttribute("style", "cursor: pointer;");
            document.getElementById('dash').setAttribute("style", "cursor: pointer;");
            
        } else {

            document.getElementById('dash').setAttribute("style", "border-bottom: solid 2px #17a2b8; cursor: pointer;");

            document.getElementById('solic').removeAttribute("style");
            document.getElementById('chamados').removeAttribute("style");

            // ADICIONA O CURSOR APÓS RETIRAR O STYLE
            document.getElementById('solic').setAttribute("style", "cursor: pointer;");
            document.getElementById('chamados').setAttribute("style", "cursor: pointer;");

        } 
        
    }

    function chama_paginas(pagina) {

        // VARIAVEIS PARA UTILIZAR COMO FILTRO DE BUSCA DOS CHAMADOS
        var periodo = document.getElementById('periodo').value;
        var usu = document.getElementById('sel_prestador').value;

        if(usu == '' || usu == null){

            usu = sessionStorage.getItem("cd_usu_sel");
        }

        var os = document.getElementById('txt_os').value;

        if(pagina == 'x'){

            //FILTRO REALIZADO 
            pagina = document.getElementById('inpt_pag_atual').value;

            //TRABALHANDO AS SESSOES
            sessionStorage.setItem("sessao_periodo", periodo);

            //alert('inclue ' + periodo);

        }else if(pagina == 'prest_inicio'){

            //APENAS MUDANCA DE PAGINA
            document.getElementById('inpt_pag_atual').value = 1;  
            pagina = 1;

            //TRABALHANDO AS SESSOES
            usu = sessionStorage.getItem("cd_usu_sel");

            //alert('periodo ' + periodo + ' | usu ' + usu);          

        }else{            

            //APENAS MUDANCA DE PAGINA
            document.getElementById('inpt_pag_atual').value = pagina;  

            //TRABALHANDO AS SESSOES
            //periodo = sessionStorage.getItem("sessao_periodo");

            document.getElementById('periodo').value = periodo;
            document.getElementById('sel_prestador').value = usu;

            //alert('coleta ' + periodo);

        }

        //ADICIONA ULTIMA PAGINA SELECIONADA NA SESSAO
        sessionStorage.setItem("sessao_ult_pg", pagina); 
        sessionStorage.setItem("periodo", periodo);


        if (pagina == '1') {    
            
            //SOLICITACOES

            $("#resultados_ajax").load("solicitacoes.php", function() {
                //alert(periodo + ' | ' + usu + ' | ' + os)
                $('#carrega_chamados').load('funcoes/chamados/ajax_solicitados_usuario_logado.php?periodo=' + periodo + '&usu=' + usu + '&os=' + os);
            });

        }

        if (pagina == '2') {

            //MEUS CHAMADOS          

            $("#resultados_ajax").load("meus_chamados.php", function() {
                //alert(periodo + ' | ' + usu + ' | ' + os)
                $('#carrega_chamados').load('funcoes/chamados/ajax_chamados_recebidos.php?periodo=' + periodo + '&usu=' + usu + '&os=' + os);
            });

        }
        
        if (pagina == '3') {

            //DASHBOARD

            $("#resultados_ajax").load("dashboard.php", function() {

                $('#carrega_dashboard').load('funcoes/dashboard/ajax_exibe_dashboard.php?periodo=' + periodo + '&usu=' + usu);

            });


        }

    }

    function chamar_abertura_chamado() {

        $('#modal_abertura_chamado').modal('show');
        $('#conteudo_modal_abertura_chamado').load('funcoes/chamados/ajax_modal_abertura_chamado.php');

    }

    function redirecionar_detalhe_chamado(id_chamado) {

        window.location.href = "detalhe_chamado.php?id=" + id_chamado;

    }

</script>