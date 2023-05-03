<?php

    include 'cabecalho.php';
?>

    <h11><i class="fa-solid fa-building"></i> Empresa</h11>
        <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>

    <div class="div_br"></div>

    <div id="mensagem_acao"></div>

    <div class="row">
   
        <div class="col-md-3 col-6" style="background-color: rgba(1,1,1,0) !important; 
        padding-top: 0px !important; padding-bottom: 0px !important;">

            Empresa
            <div class="input-group mb-3">
                <input id="ds_nova_empresa" class="form form-control" type="text">
                <div class="input-group-append">
                    <a onclick="ajax_cadastro_empresa()" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
                </div>
            </div>

        </div>

    </div>

    <!-- MODAL EDIÇÃO -->
    <div class="modal fade" id="modal_edicao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="titulo_modal">Editar empresa</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div id="conteudo_modal" class="modal-body">
                
                </div>

            </div>

        </div>

    </div>

    <div id="resultado_empresas"></div>

<?php

    include 'rodape.php';

?>

<script>

    // CARREGA A TEBELA APENAS DEPOIS DA TELA SER CARREGADA
    window.onload = function() {

        $('#resultado_empresas').load('funcoes/empresa/ajax_tabela_empresas.php');

    }

    // ADICIONAR UMA NOVA EMPRESA
    function ajax_cadastro_empresa() {

        let ds_nova_empresa = document.getElementById('ds_nova_empresa').value;
        if (ds_nova_empresa == '') { document.getElementById('ds_nova_empresa').focus(); }

        if (ds_nova_empresa == '') {
     
            var_ds_msg = 'Necessário%20preencher%20os%20campos!';
            var_tp_msg = 'alert-danger';

            $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

        } else {

            $.ajax({
            url: "funcoes/empresa/ajax_cadastro_empresa.php",
            type: "POST",
            data: {
                ds_nova_empresa,
            },
            cache: false,
            success(resp) {
                
                // LIMPA O CAMPO DE NOVA EMPRESA
                document.getElementById('ds_nova_empresa').value = '';

                // CHAMA NOVAMENTE A TEBELA DE EMPRESAS PARA ATUALIZAR A TEBELA APOS CADA CADASTRO NOVO
                $('#resultado_empresas').load('funcoes/empresa/ajax_tabela_empresas.php');

                var_ds_msg = 'Empresa%20cadastrada%20com%20sucesso!';
                var_tp_msg = 'alert-success';
                $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            }

        });

        }



    }

    // EXCLUIR EMPRESA
    function ajax_exclui_empresa(id_empresa) {

        $deseja_excluir = confirm('Deseja realmente excluir?');
        
        if ($deseja_excluir) {

            // AJAX PARA VERIFICAR SE EXISTE USUÁRIOS NA EMPRESA, ANTES DE EXCLUIR
            $.ajax({
                url: "funcoes/quantidade_usuarios_empresa.php",
                type: "POST",
                data: {
                    id: id_empresa
                },
                cache: false,
                success(quantidade) {

                    if (quantidade == 0) {

                        $.ajax({
                            url: "funcoes/ajax_exclui_empresa.php",
                            type: "POST",
                            data: {
                                id_empresa: id_empresa
                            },
                            cache: false,
                            success(resp) {

                                // CHAMA NOVAMENTE A TEBELA DE EMPRESAS PARA ATUALIZAR A TEBELA APOS CADA CADASTRO NOVO
                                $('#resultado_empresas').load('funcoes/ajax_tabela_empresas.php');

                                //MENSAGEM            
                                var_ds_msg = 'Empresa%20excluído%20com%20sucesso!';
                                var_tp_msg = 'alert-success';
                                $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
    
                            }
                        });

                    } else {

                        var_ds_msg = 'Existe%20usuários%20nesta%20empresa!';
                        var_tp_msg = 'alert-danger';

                        $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

                    };

                }
            });

        }

    }

    function ajax_modal_alterar_empresa(id_empresa) {

        $('#modal_edicao').modal('show');

        $('#conteudo_modal').load("funcoes/ajax_modal_editar_empresa.php?id=" + id_empresa);

    }


</script>