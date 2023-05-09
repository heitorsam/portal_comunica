<div id="mensagem_acao"></div>

<form method="POST" id="form_chamado" enctype='multipart/form-data'>

    <div class="row">

        <div class="col-md-12">
            Descrição:
            <input name="descricao" id="frm_descricao" type="text" class="form form-control" placeholder="Descreva...">
        </div>

    </div>

    <div class="div_br"></div>

    <div class="row">

        <div class="col-md-3">
            Empresa:
            <select onchange="preencher_grupos()" id="frm_empresa" name="empresa" class="form form-control">

            </select>

        </div>

        <div class="col-md-3">
            Grupo:
            <select name="grupo" id="frm_grupo" class="form form-control">
                
            </select>

        </div>

        <div class="col-md-3">
            Prioridade:
            <select name="prioridade" id="frm_prioridade" class="form form-control">
                <option value="B">BAIXA</option>
                <option value="M">MÉDIA</option>
                <option value="A">ALTA</option>
            </select>
        </div>

        <div class="col-md-3">
            Data prevista:
            <input name="data_prevista" id="frm_dt_prevista" type="date" class="form form-control">
        </div>

    </div>

    <div class="div_br"></div>

    <div class="row">

        <div class="col-md-12">
            Observação:
            <textarea name="observacao" id="frm_observacao" class="form form-control" style="height: 120px;">
            </textarea>

        </div>

    </div>

    <div class="div_br"></div>

    <div class="row" style="margin-left: 2px; width: 100%;">
            
        <div style="width: 30%; background-color: #46a5d4; border: dashed 1px #46a5d4; text-align: center;">  
            
            <label style="color: white; padding-top: 10px;" class="btn btn-default btn-sm center-block btn-file">

                <i class="fa fa-upload fa-1x" aria-hidden="true"></i>
                    Selecine um Arquivo!
                <input name="arquivo" type="file" id="frm_arquivo" style="display: none;">

            </label>

        </div>

        <div style="float: left; width: 70%; text-align: right;">
    
            <a onclick="abrir_chamado()" style="width: 160px;" class="mt-3 btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar</a>
    
        </div>

    </div>

</form>

<script>

    // CARREGA TODAS AS EMPRESAS NO SELECT
    $('#frm_empresa').load('funcoes/empresa/ajax_carregar_empresas_chamados.php');

    document.getElementById('frm_observacao').value = '';

    function preencher_grupos(e) {

        var id_empresa = document.getElementById('frm_empresa').value;
        
        $('#frm_grupo').load('funcoes/grupo/ajax_carregar_grupos.php?id='+id_empresa);

    }

    function abrir_chamado() {

        // VALIDACOES
        var frm_descricao = document.getElementById('frm_descricao'); if(frm_descricao.value == ''){ frm_descricao.focus(); }
        var frm_empresa = document.getElementById('frm_empresa'); if(frm_empresa.value == ''){ frm_empresa.focus(); }
        var frm_grupo = document.getElementById('frm_grupo'); if(frm_grupo.value == ''){ frm_grupo.focus(); }
        var frm_prioridade = document.getElementById('frm_prioridade'); if(frm_prioridade.value == ''){ frm_prioridade.focus(); }
        var frm_dt_prevista = document.getElementById('frm_dt_prevista'); if(frm_dt_prevista.value == ''){ frm_dt_prevista.focus(); }
        var frm_observacao = document.getElementById('frm_observacao'); if(frm_observacao.value == ''){ frm_observacao.focus(); }

        // VALIDANDO DATA
        var data_atual = new Date();
        var data_prevista = new Date(frm_dt_prevista.value);

        if (data_atual.getFullYear() > data_prevista.getFullYear()) {

            prossegue_abertura_chamado();

        } else if (data_atual.getFullYear() == data_prevista.getFullYear() &&
                    (data_atual.getMonth() < 9 || data_atual.getDate() < 9) && data_atual < data_prevista) {

            prossegue_abertura_chamado();

        } else {

            //MENSAGEM            
            var_ds_msg = 'Data%20deve%20ser%20maior%20que%20a%20data%20atual!';
            var_tp_msg = 'alert-danger';
            $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 

        }
        
        // VERIFICA NENHUM CAMPO ESTÁ VAZIO ANTES DE ABRIR UM CHAMADO
        function prossegue_abertura_chamado() {

            if(frm_descricao.value != '' && frm_empresa.value != '' && frm_grupo.value != '' && frm_prioridade.value != '' && frm_dt_prevista.value != '' && frm_observacao.value != '') {
    
                var form = document.getElementById('form_chamado');
                var formData = new FormData(form);
    
                $.ajax({
                    url: "funcoes/chamados/insert_abrir_chamado.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success(res) {
    
                        console.log(res);
    
                        if (res != 'Erro') {
    
                            ajax_envia_email(res,'Abertura de Chamado','Foi aberto um novo chamado para seu grupo.','g');
                            
                            //MENSAGEM            
                            var_ds_msg = 'Enviando%20e-mail!';
                            var_tp_msg = 'alert-primary';
                            $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
    
    
                            //AGUARDA 3 SEGUNDOS ANTES DE EXECUTAR OS COMANDOS ABAIXO
                            setTimeout(function(){                    
    
                                //MENSAGEM            
                                var_ds_msg = 'Chamado%20aberto%20com%20sucesso!';
                                var_tp_msg = 'alert-success';
                                $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
    
                                // LIMPANDO OS CAMPOS APÓS O CADASTRO CONCLUÍDO COM SUCESSO
                                frm_descricao.value = ''; frm_empresa.value = ''; frm_grupo.value = ''; frm_prioridade.value = ''; frm_dt_prevista.value = ''; frm_observacao.value = ''; frm_arquivo.value = '';
    
                                setTimeout(function(){
                                    window.location.reload(); 
                                }, 4000);       
    
                            }, 3000);
    
                        } else {
    
                            //MENSAGEM            
                            var_ds_msg = 'Erro%20ao%20abrir%20chamado!';
                            var_tp_msg = 'alert-danger';
                            $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
    
                        }
    
                    }   
    
                });
    
            } else {
    
                //MENSAGEM            
                var_ds_msg = 'Preencha%20todos%20os%20campos!';
                var_tp_msg = 'alert-danger';
                $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
    
            }


        }
    }

</script>