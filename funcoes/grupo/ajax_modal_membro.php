<?php

    $id_grupo = $_GET['idgrupo'];

?>

<div id="mensagem_acoes"></div>

<div class="row">

    <!-- INPUT PARA O JAVASCRIPT PEGAR O ID DO GRUPO PELO VALUE -->
    <input id="id_grupo" value="<?php echo $id_grupo; ?>" type="text" style="display: none;">

    <div class="col-8 col-md-5">

        <!-- Membro
        <input id="ds_novo_grupo" class="form form-control" type="text"> -->
        <div class="col-md-10 col-6" style="background-color: rgba(1,1,1,0) !important; 
            padding-top: 0px !important; padding-bottom: 0px !important;">

            Prestador
            <div class="input-group mb-3">
                <select class="form-control" id="tp_status_list"></select>               
                <div class="input-group-append">
                    <a onclick="ajax_incluir_usuario_grupo()" id="btn_incluir_membro_grupo" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
                </div>
            </div>

        </div>

    </div>


</div>

<div class="div_br"></div>

<div id="carrega_membros"></div>

<script>
    // PEGA O ID DO GRUPO QUE FOI ENVIADO 
    var id_grupo = document.getElementById('id_grupo').value;

    // CARREGA AJAX DA TABELA DE MEMBROS DO GRUPO REFERENCIADO
    $('#carrega_membros').load('funcoes/grupo/ajax_tabela_usuarios_membros.php.php?idgrupo='+id_grupo);

    // CARREGA NO INPUT TODOS OS USUARIOS QUE NÃO PERTENCEM AO GRUPO PARA REALIZAR AUTOCOMPLETE
    $('#tp_status_list').load('funcoes/empresa/consulta_usuarios_empresa.php?idgrupo='+id_grupo);

    function ajax_incluir_usuario_grupo() {

        // PEGA O VALOR DOS OPTIONS GERADOS
        id_usuario_grupo = document.getElementById('tp_status_list').value;

        $.ajax({
            url: "funcoes/grupo/incluir_usuario_grupo.php",
            type: "POST",
            data: {
                id_usuario_grupo: id_usuario_grupo,
                id_grupo: id_grupo
            },
            cache: false,
            success(resp) {

                // CARREGA NOVAMENTE AJAX DA TABELA DE MEMBROS DO GRUPO REFERENCIADO
                $('#carrega_membros').load('funcoes/empresa/ajax_tabela_usuarios_empresa.php?idgrupo='+id_grupo);

                // CARREGA NOVAMENTO NO INPUT TODOS OS USUARIOS QUE NÃO PERTENCEM AO GRUPO PARA REALIZAR AUTOCOMPLETE
                $('#tp_status_list').load('funcoes/empresa/consulta_usuarios_empresa.php?idgrupo='+id_grupo);

                // LIMPA O CAMPO APÓS INCLUIR COM SUCESSO
                document.getElementById('tp_status_edit').value = '';

                var_ds_msg = 'Membro%20incluído%20com%20sucesso!';
                var_tp_msg = 'alert-success';
                $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
                
            }
        });       

    }

    function excluir_usuario_grupo(id_usuario, id_grupo) {

        $.ajax({
            url: "funcoes/grupo/excluir_usuario_grupo.php",
            type: "POST",
            data: {
                id_usuario: id_usuario,
                id_grupo: id_grupo
            },
            cache: false,
            success(res) {

                // CARREGA NOVAMENTE AJAX DA TABELA DE MEMBROS DO GRUPO REFERENCIADO
                $('#carrega_membros').load('funcoes/empresa/ajax_tabela_usuarios_empresa.php?idgrupo='+id_grupo+'&idusuario='+id_usuario);

                // CARREGA NOVAMENTO NO INPUT TODOS OS USUARIOS QUE NÃO PERTENCEM AO GRUPO PARA REALIZAR AUTOCOMPLETE
                $('#tp_status_list').load('funcoes/empresa/consulta_usuarios_empresa.php?idgrupo='+id_grupo);

                if (res == 'sucesso') {

                    //MENSAGEM            
                    var_ds_msg = 'Membro%20excluído%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                } else {

                    console.log(res);

                    //MENSAGEM            
                    var_ds_msg = 'Ocorreu%20um%20erro!';
                    var_tp_msg = 'alert-danger';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                }

            }
        })

        

    }

</script>