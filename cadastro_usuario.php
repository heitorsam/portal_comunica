<?php
    include 'cabecalho.php';
?>

    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>
    <div class="div_br"> </div>
    
    <!-- FORMULÁRIO CADASTRO DE USUÁRIOS -->
    <div class="containerCadastroUsuarios">

        <div class="row">

            <div class="col-md">

                Nome:
                <input type="text" class="form form-control" placeholder="Nome completo">

            </div>

            
            <div class="col-md-3 esconde">

                CPF:
                <input type="text" class="form form-control" placeholder="CPF">

            </div>

            <div class="col-md-2 esconde">

                Data de Nascimento:
                <input type="date" class="form form-control">

            </div>

        </div>

        <div class="div_br"></div>

        <div class="row">

            <div class="col-md-2">

                Empresa:
                <select class="form form-control">
    
                    <option value="">Santa Casa</option>
                    <option value="">Associação</option>
    
                </select>

            </div>

            <div class="col-md">
                
                Senha:
                <input type="password" class="form form-control" placeholder="Senha">

            </div>

            <div class="col-md-2">

                Tipo de Usuário:
                <select class="form form-control">
        
                    <option value="">Comum</option>
                    <option value="">Administrador</option>

                </select>

            </div>

            <div class="col-md-3">
                Foto:
                <div style="background-color: #d5d5d5cc; border: dashed 1px #cbced1; text-align: center;">  
                    <label style="padding-top: 10px;"class="btn btn-default btn-sm center-block btn-file">

                        <i class="fa fa-upload fa-1x" aria-hidden="true"></i>
                            Selecine um Arquivo!
                        <input type="file" id="foto_usuario" style="display: none;">

                    </label>
                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md">

                E-mail:
                <input class="form form-control" type="email" placeholder="Informe o e-mail">

            </div>

            <button style="height: 50px;" class="mt-4 col-md-3 btn btn-primary"><i class="fa-solid fa-plus"></i> Adicionar</button>

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

    // CHAMA A TABELA DE USUÁRIOS CADASTRADOS
    $('#resultado_usuarios').load('./funcoes/ajax_tabela_usuarios.php');

</script>