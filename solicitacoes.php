<button onclick="chamar_abertura_chamado()" class="botao_home"><i class="fa-solid fa-plus"></i> Chamado</button>

<div class="div_br"></div>
<?php

  $inicio = $_GET["inicio"];
  $fim = $_GET["fim"];
  
  echo '<input value="" type="text">';
  echo '<input value="" type="text">';
?>

<div id="carrega_chamados"></div>

<!-- MODAL SOLICITAÇÕES -->
<div class="modal fade" id="modal_abertura_chamado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="titulo_modal">Abertura de chamado</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div id="conteudo_modal_abertura_chamado" class="modal-body">
        ...
      </div>

    </div>

  </div>

</div>

<script>

    $('#carrega_chamados').load('funcoes/chamados/ajax_solicitados_usuario_logado.php');

    function chamar_abertura_chamado() {

        $('#modal_abertura_chamado').modal('show');
        $('#conteudo_modal_abertura_chamado').load('funcoes/ajax_modal_abertura_chamado.php');

    }

</script>