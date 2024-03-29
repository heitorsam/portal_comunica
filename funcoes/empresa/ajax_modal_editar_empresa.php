<?php

    include '../../conexao.php';

    $id_empresa = $_GET['id'];

    $cons_buscar_empresa = "SELECT *
                            FROM bd_comunic.EMPRESA emp
                            WHERE emp.CD_EMPRESA = '$id_empresa'";

    $res = mysqli_query($conn, $cons_buscar_empresa);

    $empresa_editavel = mysqli_fetch_array($res);

?>

<div id="mensagem_acoes"></div>

<form method="POST" id="form_edicao" enctype='multipart/form-data'>

    <input name="id_empresa" value="<?php echo $id_empresa; ?>" style="display: none;">
    
    <div class="row">
        
        <div class="col-md">

            Empresa:
            <input value="<?php echo $empresa_editavel['DS_EMPRESA']; ?>" id="nome_edicao" name="ds_empresa" type="text" class="form form-control" placeholder="Novo nome da empresa">

        </div>

    </div>

</form>

<div class="modal-footer">

    <button onclick="ajax_editar_empresa()" id="btn_salvar_edicao" type="button" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>

    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Fechar</button>

</div>

<script>

    function ajax_editar_empresa(event) {

        var empresa_nova = document.getElementById('nome_edicao').value;
        var form_edicao = document.getElementById('form_edicao');
        var formDataEdicao = new FormData(form_edicao);

        // VERIFICA SE O CAMPO ESTÁ VAZIO
        if (empresa_nova != '') {

            $.ajax({
                url: "funcoes/empresa/ajax_editar_empresa.php",
                type: "POST",
                data: formDataEdicao,
                processData: false,
                contentType: false,
                success(res) {
    
                    // RECARREGA A TEBELA DE EMPRESAS NA PÁGINA
                    $('#resultado_empresas').load('funcoes/ajax_tabela_empresas.php');

                    if(res == 'sucesso'){
    
                        //MENSAGEM            
                        var_ds_msg = 'Empresa%20editada%20com%20sucesso!';
        
                        //var_tp_msg = 'alert-success';
                        var_tp_msg = 'alert-success';
                        
                        //var_tp_msg = 'alert-primary';
                        $('#mensagem_acoes').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);
                    
                    }else{

                        console.log(res);

                        //MENSAGEM            
                        var_ds_msg = 'Ocorreu%20um%20erro!';
                        var_tp_msg = 'alert-danger';
                        $('#mensagem_acao').load('config/mensagem/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                    }

                    $('#resultado_empresas').load('funcoes/empresa/ajax_tabela_empresas.php');

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