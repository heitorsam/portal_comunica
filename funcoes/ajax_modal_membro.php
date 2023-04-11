<?php

    $id_grupo = $_GET['idgrupo'];

?>

<div id="mensagem_acoes"></div>

<div class="row">

    <!-- INPUT PARA O JAVASCRIPT PEGAR O ID DO GRUPO PELO VALUE -->
    <input id="id_grupo" value="<?php echo $id_grupo; ?>" type="text" style="display: none;">

    <div class="col-md-3">

        <!-- Membro
        <input id="ds_novo_grupo" class="form form-control" type="text"> -->
        <div class="div_br"></div>

        <input type="text" id="tp_status_edit" list="tp_status_list" class="form-control">

        <datalist id="tp_status_list" style="max-height: 200px; overflow-y: auto;">
            
        </datalist>

    </div>

    <div class="col-md-1">

        <a onclick="ajax_incluir_usuario_grupo()" id="btn_incluir_membro_grupo" class="mt-3 btn btn-primary"><i class="fa-solid fa-plus"></i></a>

    </div>

</div>

<div class="div_br"></div>

<div id="carrega_membros"></div>

<script>
    // PEGA O ID DO GRUPO QUE FOI ENVIADO 
    var id_grupo = document.getElementById('id_grupo').value;

    // CARREGA AJAX DA TABELA DE MEMBROS DO GRUPO REFERENCIADO
    $('#carrega_membros').load('funcoes/ajax_tabela_usuarios_empresa.php?idgrupo='+id_grupo);

    // CARREGA NO INPUT TODOS OS USUARIOS QUE NÃO PERTENCEM AO GRUPO PARA REALIZAR AUTOCOMPLETE
    $('#tp_status_list').load('funcoes/consulta_usuarios_empresa.php?idgrupo='+id_grupo);

    function ajax_incluir_usuario_grupo() {

        let campo_usuario = document.getElementById('tp_status_edit').value;
        if (campo_usuario == '') { document.getElementById('tp_status_edit').focus(); }

        if (campo_usuario == '') {
     
            var_ds_msg = 'Necessário%20preencher%20os%20campos!';
            var_tp_msg = 'alert-danger';

            $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

        } else {

            // PEGA O VALOR DOS OPTIONS GERADOS
            var val = $('#tp_status_edit').val();
            var id_usuario_grupo = $('#tp_status_list option').filter(function() {
    
                return this.value == val;
    
            }).data('value');
    
            $.ajax({
                url: "funcoes/incluir_usuario_grupo.php",
                type: "POST",
                data: {
                    id_usuario_grupo: id_usuario_grupo,
                    id_grupo: id_grupo
                },
                cache: false,
                success(resp) {

                    // CARREGA NOVAMENTE AJAX DA TABELA DE MEMBROS DO GRUPO REFERENCIADO
                    $('#carrega_membros').load('funcoes/ajax_tabela_usuarios_empresa.php?idgrupo='+id_grupo);
    
                    // CARREGA NOVAMENTO NO INPUT TODOS OS USUARIOS QUE NÃO PERTENCEM AO GRUPO PARA REALIZAR AUTOCOMPLETE
                    $('#tp_status_list').load('funcoes/consulta_usuarios_empresa.php?idgrupo='+id_grupo);

                    // LIMPA O CAMPO APÓS INCLUIR COM SUCESSO
                    document.getElementById('tp_status_edit').value = '';

                    var_ds_msg = 'Membro%20incluído%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
                    
                }
            });

        }

    }

    function excluir_usuario_grupo(id_usuario, id_grupo) {

        $resposta_confirmacao = confirm('Deseja realmente excluir o usuário do grupo?');

        if ($resposta_confirmacao) {

            $.ajax({
                url: "funcoes/excluir_usuario_grupo.php",
                type: "POST",
                data: {
                    id_usuario: id_usuario,
                    id_grupo: id_grupo
                },
                cache: false,
                success(resp) {

                    // CARREGA NOVAMENTE AJAX DA TABELA DE MEMBROS DO GRUPO REFERENCIADO
                    $('#carrega_membros').load('funcoes/ajax_tabela_usuarios_empresa.php?idgrupo='+id_grupo);

                    // CARREGA NOVAMENTO NO INPUT TODOS OS USUARIOS QUE NÃO PERTENCEM AO GRUPO PARA REALIZAR AUTOCOMPLETE
                    $('#tp_status_list').load('funcoes/consulta_usuarios_empresa.php?idgrupo='+id_grupo);

                    var_ds_msg = 'Membro%20excluído%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                }
            })

        }

    }

</script>