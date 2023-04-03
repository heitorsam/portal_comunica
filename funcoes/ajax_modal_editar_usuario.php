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
            <input value="<?php echo $usuario_editavel['NM_USUARIO']; ?>" id="nome" name="nome" type="text" class="form form-control" placeholder="Nome completo">

        </div>

        
        <div class="col-md-3 esconde">

            CPF:
            <input value="<?php echo $usuario_editavel['CPF']; ?>" id="cpf" name="cpf" type="text" class="form form-control" placeholder="CPF">

        </div>

    </div>

    <div class="div_br"></div>

    <div class="row">

        <div class="col-md-2">

            Empresa:
            <select id="empresa" name="empresa" class="form form-control">

                <option value="1">Santa Casa</option>
                <option value="2">Associação</option>

            </select>

        </div>

        <div class="col-md">
            
            Senha:
            <input value="<?php echo $usuario_editavel['SENHA']; ?>" id="senha" name="senha" type="text" class="form form-control" placeholder="Senha">

        </div>

        <div class="col-md-2">

            Tipo de Usuário:
            <select id="tp_usuario" name="tp_usuario" class="form form-control">
    
                <option value="C">Comum</option>
                <option value="A">Administrador</option>

            </select>

        </div>

        <div class="col-md-3">
            Foto:
            <div style="background-color: #d5d5d5cc; border: dashed 1px #cbced1; text-align: center;">  
                <label style="padding-top: 10px;"class="btn btn-default btn-sm center-block btn-file">

                    <i class="fa fa-upload fa-1x" aria-hidden="true"></i>
                        Selecine um Arquivo!
                    <input type="file" id="foto_usuario" name="foto_usuario" style="display: none;">

                </label>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md">

            E-mail:
            <input value="<?php echo $usuario_editavel['EMAIL']; ?>" id="email" name="email" class="form form-control" type="email" placeholder="Informe o e-mail">

        </div>

    </div>

</form>

<div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

    <button onclick="ajax_editar_usuario()" id="btn_salvar_edicao" type="button" class="btn btn-primary">Salvar</button>

</div>

<script>

    function ajax_editar_usuario(event) {

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

    };


</script>