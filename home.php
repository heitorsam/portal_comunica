<?php

    include 'cabecalho.php';

?>

<input id="inpt_pag_atual" hidden>

    <div class="row">

        <div style="width: content; float: left;">
            <h11><i class="fa-solid fa-list efeito-zoom" aria-hidden="true"></i> Home</h11>
        </div>
        
        <div style="width: content; float: left; padding-left: 20px;">

            <input onchange="chama_paginas('x')" id="periodo" class="form form-control" type="month">

        </div>

    </div>

    <div class="div_br"></div>
    <div class="div_br"></div>

    <div class="row">

        <div class="col-sm-4">

            <h11 id="solic" onclick="chama_paginas('1'), ajax_style('1')" style="cursor: pointer;"><i class="fa-solid fa-phone-volume"></i> Solicitações</h11>

        </div>

        <div class="col-sm-4">

            <h11  id="chamados" onclick="chama_paginas('2'), ajax_style('2')" style="cursor: pointer;"><i class="fa-solid fa-headset"></i> Meus chamados</h11>

        </div>

        <div class="col-sm-4">

            <h11 id="dash" onclick="chama_paginas('3'), ajax_style('3')" style="cursor: pointer;"><i class="fa-solid fa-chart-line"></i> Dashboard</h11>

        </div>

    </div>

    <div class="div_br"></div>

    <div id="resultados_ajax"></div>
    
<?php

    include 'rodape.php';

?>

<script>
    // VARIAVEL USADA PARA PASSAR COMO PARAMETRO NO MOMENTO DE CHAMAR A FUNC chama_paginas PARA FILTROS

    js_agora = new Date();

    if((js_agora.getMonth()+1) <= 9){

        js_agora_format = js_agora.getFullYear() + "-0" + (js_agora.getMonth()+1);

    }else{

        js_agora_format = js_agora.getFullYear() + "-" + js_agora.getMonth();
    }
    
    document.getElementById('periodo').value = js_agora_format;

    chama_paginas('1');
    ajax_style('1');

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

        var periodo = document.getElementById('periodo').value;

        if(pagina == 'x'){
            pagina = document.getElementById('inpt_pag_atual').value;
        }

        if (pagina == '1') {

            pagina_atual = 1;
            document.getElementById('inpt_pag_atual').value = pagina_atual;  
 
            $("#resultados_ajax").load("solicitacoes.php", function() {
                $('#carrega_chamados').load('funcoes/chamados/ajax_solicitados_usuario_logado.php?periodo=' + periodo);
            });

        } else if (pagina == '2') {

            pagina_atual = 2;
            document.getElementById('inpt_pag_atual').value = pagina_atual;  

            $("#resultados_ajax").load("meus_chamados.php", function() {
                $('#carrega_chamados').load('funcoes/chamados/ajax_chamados_recebidos.php?periodo=' + periodo);
            });


        } else {

            pagina_atual = 3;
            document.getElementById('inpt_pag_atual').value = pagina_atual;  
            $("#resultados_ajax").load("meus_chamados.php", function() {
                //alert('rafa lindo');
            });

        }

    }

    function chamar_abertura_chamado() {

        $('#modal_abertura_chamado').modal('show');
        $('#conteudo_modal_abertura_chamado').load('funcoes/ajax_modal_abertura_chamado.php');

    }

    function redirecionar_detalhe_chamado(id_chamado) {

        window.location.href = "detalhe_chamado.php?id=" + id_chamado;

    }

</script>