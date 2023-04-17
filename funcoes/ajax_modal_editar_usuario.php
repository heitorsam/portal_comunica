<?php

    include '../conexao.php';

    $id_usuario = $_GET['id'];

    $cons_buscar_usuario = "SELECT *
                            FROM portal_comunica.USUARIO usu
                            WHERE usu.CD_USUARIO = '$id_usuario'";

    $res = mysqli_query($conn, $cons_buscar_usuario);

    $usuario_editavel = mysqli_fetch_array($res);

?>

<div id="mensagem_acoes"></div>

<form method="POST" id="form_edicao" enctype='multipart/form-data'>

    <input name="id_usuario" value="<?php echo $id_usuario; ?>" style="display: none;">
    
    <div class="row">
        
        <div class="col-md">

            Nome:
            <input value="<?php echo $usuario_editavel['NM_USUARIO']; ?>" id="nome_editar" name="nome" type="text" class="form form-control" placeholder="Nome completo">

        </div>

        
        <div class="col-md-3 esconde">

            CPF:
            <input value="<?php echo $usuario_editavel['CPF']; ?>" id="cpf_editar" name="cpf" type="text" class="form form-control" placeholder="CPF">

        </div>

    </div>

    <div class="div_br"></div>

    <div class="row">

        <div class="col-md-3">

            Empresa:
            <select id="empresa_edicao" name="empresa" class="form form-control">

            </select>

        </div>

        <div class="col-md-3">
            
            Senha:
            <input value="<?php echo $usuario_editavel['SENHA']; ?>" id="senha_editar" name="senha" type="text" class="form form-control" placeholder="Senha">

        </div>

        <div class="col-md-2">

            Tipo de Usuário:
            <select id="tp_usuario" name="tp_usuario" class="form form-control">
    
                <option value="C">Comum</option>
                <option value="A">Administrador</option>

            </select>

        </div>

        <div class="col-md-4">

            E-mail:
            <input value="<?php echo $usuario_editavel['EMAIL']; ?>" id="email_editar" name="email" class="form form-control" type="email" placeholder="Informe o e-mail">

        </div>

    </div>

</form>

<div class="modal-footer" style="margin-top: 20px;">

    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Fechar</button>

    <button onclick="ajax_editar_usuario()" id="btn_salvar_edicao" type="button" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>

</div>

<script>

    // CARREGA TODAS AS EMPRESAS NO SELECT
    $('#empresa_edicao').load('funcoes/ajax_carregar_empresas.php');

    function ajax_editar_usuario(event) {

        // VALIDAÇÕES
        var frm_email_editar = document.getElementById('email_editar'); if(frm_email_editar.value == ''){ frm_email_editar.focus(); }
        var frm_senha_editar = document.getElementById('senha_editar'); if(frm_senha_editar.value == ''){ frm_senha_editar.focus(); }
        var frm_cpf_editar = document.getElementById('cpf_editar'); if(frm_cpf_editar.value == ''){ frm_cpf_editar.focus(); }
        var frm_nome_editar = document.getElementById('nome_editar'); if(frm_nome_editar.value == ''){ frm_nome_editar.focus(); }


        if(frm_nome_editar.value != '' && frm_cpf_editar.value != '' && frm_senha_editar.value != '' && frm_email_editar.value != '') {

            let form_edicao = document.getElementById('form_edicao');
            let formDataEdicao = new FormData(form_edicao);

            $.ajax({
                url: "funcoes/ajax_editar_usuario.php",
                type: "POST",
                data: formDataEdicao,
                processData: false,
                contentType: false,
                success(resp) {

                    // RECARREGA A TEBELA DE USUÁRIOS NA PÁGINA
                    $('#resultado_usuarios').load('funcoes/ajax_tabela_usuarios.php');

                    //MENSAGEM            
                    var_ds_msg = 'Usuário%20editado%20com%20sucesso!';

                    //var_tp_msg = 'alert-success';
                    var_tp_msg = 'alert-success';
                    
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                }

            });

        } else {

            //MENSAGEM            
            var_ds_msg = 'Preencha%20todos%20os%20campos!';
            //var_tp_msg = 'alert-success';
            //var_tp_msg = 'alert-success';
            var_tp_msg = 'alert-danger';
            $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

        }

    };


</script>