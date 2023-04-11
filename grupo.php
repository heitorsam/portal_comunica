<?php

    include 'cabecalho.php';

?>

    <h11><i class="fa-solid fa-folder-tree"></i> Grupo</h11>
        <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>

    <div id="mensagem_acao"></div>

    <div class="div_br"></div>

    <div class="row">

        <div class="col-md-3">

            Grupo
            <input id="ds_novo_grupo" class="form form-control" type="text">

        </div>

        <div class="col-md-1">

            <a onclick="incluir_grupo()" class="mt-4 btn btn-primary"><i class="fa-solid fa-plus"></i></a>

        </div>

    </div>

    <div class="div_br"></div>

    <div id="carrega_grupos"></div>

    <!-- MODAL MEMBRO -->
    <div class="modal fade" id="modal_membros" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                <h5 class="modal-title" id="titulo_modal">Membros</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

                </div>

                <div id="conteudo_modal" class="modal-body">
                ...
                </div>

            </div>

        </div>

    </div>

    <!-- MODAL EDIÇÃO -->
    <div class="modal fade" id="modal_edicao_grupo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                <h5 class="modal-title" id="titulo_modal">Editar grupo</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

                </div>

                <div id="conteudo_modal_edicao" class="modal-body">
                
                </div>

            </div>

        </div>

    </div>

<?php

    include 'rodape.php';

?>

<script>

    window.onload = function() {

        $('#carrega_grupos').load('funcoes/ajax_tabela_grupos.php');

    }

    function ajax_chamar_modal_membro(id_grupo) {

        $('#modal_membros').modal('show');

        $('#conteudo_modal').load('funcoes/ajax_modal_membro.php?idgrupo='+id_grupo);

    }

    function incluir_grupo() {

        var ds_novo_grupo = document.getElementById('ds_novo_grupo').value;

        $.ajax({
            url: "funcoes/incluir_grupo.php",
            method: "POST",
            data: {
                novo_grupo: ds_novo_grupo
            },
            cache: false,
            success(res) {

                // LIMPA O CAMPO APÓS A CONCLUSÃO
                document.getElementById('ds_novo_grupo').value = '';

                // RECARREGA A TABELA DOS GRUPOS
                $('#carrega_grupos').load('funcoes/ajax_tabela_grupos.php');

                //MENSAGEM            
                var_ds_msg = 'Grupo%20incluído%20com%20sucesso!';
                var_tp_msg = 'alert-success';
                $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            }
        });

    }

    function ajax_chamar_modal_edicao(id_grupo) {

        $('#modal_edicao_grupo').modal('show');

        $('#conteudo_modal_edicao').load('funcoes/ajax_modal_edicao_grupo.php?id='+id_grupo);

    }

    function excluir_grupo(id_grupo) {

        $excluir_grupo = confirm('Deseja mesmo excluir este grupo?');

        if ($excluir_grupo == true) {

            $.ajax({
                url: "funcoes/excluir_grupo.php",
                method: "POST",
                data: {
                    id_grupo: id_grupo
                },
                cache: false,
                success(res) {
    
                    // RECARREGA A TABELA DOS GRUPOS
                    $('#carrega_grupos').load('funcoes/ajax_tabela_grupos.php');

                    //MENSAGEM            
                    var_ds_msg = 'Grupo%20excluído%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
    
                }
            });

        }


    }
    

</script>