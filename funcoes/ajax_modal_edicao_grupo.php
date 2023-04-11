<?php

    include '../conexao.php';

    $id_grupo = $_GET['id'];

    $cons_buscar_empresa = "SELECT *
                            FROM portal_comunica.GRUPO grp
                            WHERE grp.CD_GRUPO = $id_grupo";

    $res = mysqli_query($conn, $cons_buscar_empresa);

    $grupo_editavel = mysqli_fetch_array($res);

?>

<div id="mensagem_acoes_grupo_edicao"></div>

<form method="POST" id="form_edicao_grupo">

    <input id="id_grupo" name="id_grupo" value="<?php echo $id_grupo; ?>" style="display: none;">
    
    <div class="row">
        
        <div class="col-md">

            Grupo:
            <input value="<?php echo $grupo_editavel['DS_GRUPO']; ?>" id="nome_grupo_edicao" name="ds_grupo" type="text" class="form form-control" placeholder="Novo nome da empresa">

        </div>

    </div>

</form>

<div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

    <button onclick="ajax_editar_grupo()" id="btn_salvar_edicao" type="button" class="btn btn-primary">Salvar</button>

</div>

<script>

    function ajax_editar_grupo(event) {

        var id_empresa_selecionada = document.getElementById('id_grupo').value;
        var empresa_nova = document.getElementById('nome_grupo_edicao').value;

        // VERIFICA SE O CAMPO ESTÁ VAZIO
        if (empresa_nova != '') {

            $.ajax({
                url: "funcoes/editar_grupo.php",
                type: "POST",
                data: {
                    id_empresa_selecionada: id_empresa_selecionada,
                    ds_empresa_nova: empresa_nova
                },
                cache: false, 
                success(resp) {

                    // RECARREGA A TEBELA DE GRUPOS NA PÁGINA
                    $('#carrega_grupos').load('funcoes/ajax_tabela_grupos.php');
    
                    //MENSAGEM            
                    var_ds_msg = 'Grupo%20alterado%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                   
                    $('#mensagem_acoes_grupo_edicao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
    
                }
    
            });

        } else {

            //MENSAGEM            
            var_ds_msg = 'Necessário%20preencher%20os%20campos!';
    
            //var_tp_msg = 'alert-success';
            var_tp_msg = 'alert-danger';
            
            //var_tp_msg = 'alert-primary';
            $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

        }


    };


</script>