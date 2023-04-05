<?php
    include 'cabecalho.php';
?>

    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>
    <div class="div_br"></div>

    <div id="mensagem_acao"></div>

    <!-- FORMULÁRIO CADASTRO DE USUÁRIOS -->
    <form method="POST" id="form" enctype='multipart/form-data' class="containerCadastroUsuarios">
        

        <div class="row">
        
            <div class="col-md">

                Nome:
                <input id="nome" name="nome" type="text" class="form form-control" placeholder="Nome completo">

            </div>

            
            <div class="col-md-3 esconde">

                CPF:
                <input id="cpf" name="cpf" type="text" class="form form-control" placeholder="CPF">

            </div>

            <div class="col-md-2 esconde">

                Data de Nascimento:
                <input id="data_nasc" name="data_nasc" type="date" class="form form-control">

            </div>

        </div>

        <div class="div_br"></div>

        <div class="row">

            <div class="col-md-2">

                Empresa:
                <select id="empresa" name="empresa" class="form form-control">
    
                    
    
                </select>

            </div>

            <div class="col-md">
                
                Senha:
                <input id="senha" name="senha" type="text" class="form form-control" placeholder="Senha">

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

            <div class="col-md-10">

                E-mail:
                <input id="email" name="email" class="form form-control" type="email" placeholder="Informe o e-mail">

            </div>

            <div class="col-md-2">

                <br>
                <a class="btn btn-primary" onclick="adicionar_usuario()"><i class="fa-solid fa-plus"></i> Adicionar</a>

            </div>

           
        </div>

</form>

<!-- MODAL EDIÇÃO -->
<div class="modal fade" id="modal_edicao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="titulo_modal">Editar usuário</h5>

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
        

    <div class="div_br"></div>
    <div class="div_br"></div>

    <!-- RENDERIZAÇÃO DOS USUÁRIOS -->
    <div class="mt-4" id="resultado_usuarios"></div>



<?php

    include 'rodape.php';
    
?>

<script>

    window.onload = function(){

        // CHAMA A TABELA DE USUÁRIOS CADASTRADOS
        $('#resultado_usuarios').load('funcoes/ajax_tabela_usuarios.php');

        // CARREGA TODAS AS EMPRESAS NO SELECT
        $('#empresa').load('funcoes/ajax_carregar_empresas.php');

    }

    function adicionar_usuario() {
        let form = document.getElementById('form');

        // INICIALIZA COM OS DADOS DO FORM
        let formData = new FormData(form);

        $.ajax({
            url: "funcoes/ajax_cadastro_usuario.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success(resp) {

                // CHAMA NOVAMENTE A TEBELA DE USUÁRIOS PARA ATUALIZAR A TEBELA APOS CADA CADASTRO NOVO
                $('#resultado_usuarios').load('funcoes/ajax_tabela_usuarios.php');

                //MENSAGEM            
                var_ds_msg = 'Usuário%20cadastrado%20com%20sucesso!';
                //var_tp_msg = 'alert-success';
                var_tp_msg = 'alert-success';
                //var_tp_msg = 'alert-primary';
                $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

            }

        });

    }

    // EXCLUIR USUÁRIO
    function ajax_exclui_usuario(id_usuario) {

        $deseja_excluir = confirm('Deseja realmente excluir?');

        if ($deseja_excluir) {

            $.ajax({
                url: "funcoes/ajax_exclui_usuario.php",
                type: "POST",
                data: {
                    id_usuario: id_usuario
                },
                cache: false,
                success(resp) {

                    // CHAMA NOVAMENTE A TEBELA DE USUÁRIOS PARA ATUALIZAR A TEBELA APOS CADA CADASTRO NOVO
                    $('#resultado_usuarios').load('funcoes/ajax_tabela_usuarios.php');

                }
            });

        }

    }

    // ABRIR MODAL DE ALTERAÇÃO DE USUÁRIO
    function ajax_modal_alterar_usuario(id_usuario) {

        $('#modal_edicao').modal('show');

        $('#conteudo_modal').load("funcoes/ajax_modal_editar_usuario.php?id=" + id_usuario);

    }

    function mensagem_ok(){

        //MENSAGEM            
        var_ds_msg = 'Usuário%20cadastrado%20com%20sucesso!';
        //var_tp_msg = 'alert-success';
        var_tp_msg = 'alert-success';
        //var_tp_msg = 'alert-primary';
        $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

    }

</script>