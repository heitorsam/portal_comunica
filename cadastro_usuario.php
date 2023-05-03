<?php
    include 'cabecalho.php';
?>

    <h11><i class="fa-solid fa-user-plus"></i> Usuários</h11>
        <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>

    <div class="div_br"></div>

    <div id="mensagem_acao"></div>

    <!-- FORMULÁRIO CADASTRO DE USUÁRIOS -->
    <form method="POST" id="form" enctype='multipart/form-data' class="containerCadastroUsuarios">
        

        <div class="row">
        
            <div class="col-md">

                Nome:
                <input id="nome" name="nome" type="text" class="form form-control" placeholder="Nome completo" required>

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

            <div class="col-md-3">
                
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
        $('#resultado_usuarios').load('funcoes/usuario/ajax_tabela_usuarios.php');

        // CARREGA TODAS AS EMPRESAS NO SELECT
        $('#empresa').load('funcoes/ajax_carregar_empresas.php');

    }

    function adicionar_usuario() {

        //VALIDACOES
        var frm_email = document.getElementById('email'); if(frm_email.value == ''){ frm_email.focus(); }
        var frm_senha = document.getElementById('senha'); if(frm_senha.value == ''){ frm_senha.focus(); }
        var frm_nasc = document.getElementById('data_nasc'); if(frm_nasc.value == ''){ frm_nasc.focus(); }
        var frm_cpf = document.getElementById('cpf'); if(frm_cpf.value == ''){ frm_cpf.focus(); }
        var frm_nome = document.getElementById('nome'); if(frm_nome.value == ''){ frm_nome.focus(); }
        
        if(frm_nome.value != '' && frm_cpf.value != '' && frm_nasc.value != '' && frm_senha.value != '' && frm_email.value != ''){
        
            let form = document.getElementById('form');

            // INICIALIZA COM OS DADOS DO FORM
            let formData = new FormData(form);

            $.ajax({
                url: "funcoes/usuario/ajax_cadastro_usuario.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success(resp) {

                    // CHAMA NOVAMENTE A TEBELA DE USUÁRIOS PARA ATUALIZAR A TEBELA APOS CADA CADASTRO NOVO
                    $('#resultado_usuarios').load('funcoes/usuario/ajax_tabela_usuarios.php');

                    //MENSAGEM            
                    var_ds_msg = 'Usuário%20cadastrado%20com%20sucesso!';
                    //var_tp_msg = 'alert-success';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

                    // LIMPANDO OS CAMPOS APÓS O CADASTRO CONCLUÍDO COM SUCESSO
                    frm_nome.value = ''; frm_cpf.value = ''; frm_nasc.value = ''; frm_senha.value = ''; frm_email.value = '';

                }   

            });

        }else{

            //MENSAGEM            
            var_ds_msg = 'Preencha%20todos%20os%20campos!';
            //var_tp_msg = 'alert-success';
            //var_tp_msg = 'alert-success';
            var_tp_msg = 'alert-danger';
            $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 


        }

    }

    // EXCLUIR USUÁRIO
    function ajax_exclui_usuario(id_usuario) {

        $deseja_excluir = confirm('Deseja realmente excluir?');

        if ($deseja_excluir) {

            $.ajax({
                url: "funcoes/usuario/ajax_exclui_usuario.php",
                type: "POST",
                data: {
                    id_usuario: id_usuario
                },
                cache: false,
                success(resp) {

                    // EXECUTA A QUERY PARA EXCLUIR TODAS AS LIGAÇÕES DO USUÁRIO NO GRUPO/USUARIO
                    $.ajax({
                        type: "POST",
                        url: "funcoes/usuario/excluir_usuario_grupos.php",
                        data: {
                            id_usuario: id_usuario
                        }
                    });

                    // CHAMA NOVAMENTE A TEBELA DE USUÁRIOS PARA ATUALIZAR A TEBELA APOS CADA CADASTRO NOVO
                    $('#resultado_usuarios').load('funcoes/ajax_tabela_usuarios.php');

                    //MENSAGEM            
                    var_ds_msg = 'Usuário%20excluido%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

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