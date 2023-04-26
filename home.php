<?php

    include 'cabecalho.php';

?>

    <div class="row">
        <div class="col-md-2">
            <h11><i class="fa-solid fa-list efeito-zoom" aria-hidden="true"></i> Home</h11>
        </div>
        
        <h11>Período:</h11>
        <div class="col-md-2">

            <input id="periodo_ini" class="form form-control" type="month">

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

        // PEGAR O PERÍODO DE DATAS PARA USAR COMO FILTROS
        var data_inicio = document.getElementById('periodo_ini').value;
        var data_fim = document.getElementById('periodo_fim').value;

        if (pagina == '1') {

            if (data_inicio && data_fim) {

                $('#resultados_ajax').load('solicitacoes.php?inicio=' + data_inicio + '&fim=' + data_fim);

            } else {

                $('#resultados_ajax').load('solicitacoes.php');

            }

        } else if (pagina == '2') {

            if (data_inicio && data_fim) {

                $('#resultados_ajax').load('meus_chamados.php?inicio=' + data_inicio + '&fim=' + data_fim);

            } else {

                $('#resultados_ajax').load('meus_chamados.php');

            }

        } else {

            $('#resultados_ajax').load('dashboard.php');

        }

    }

    function redirecionar_detalhe_chamado(id_chamado) {

        window.location.href = "detalhe_chamado.php?id=" + id_chamado;

    }

</script>