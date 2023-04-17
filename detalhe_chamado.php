<?php

    include 'cabecalho.php';

    include 'conexao.php';

    $id_chamado = $_GET['id'];

    $query_buscar_informacoes_chamado = "SELECT usu.NM_USUARIO
                                        FROM portal_comunica.CHAMADO ch
                                        INNER JOIN portal_comunica.USUARIO usu
                                            ON usu.CD_USUARIO = ch.CD_USUARIO_CADASTRO
                                        WHERE ch.CD_CHAMADO = $id_chamado";
    
    $res = mysqli_query($conn, $query_buscar_informacoes_chamado);

    $nm_usuario = mysqli_fetch_row($res)[0];

?>

    <h11><i class="fa-solid fa-circle-info"></i> Detalhe do chamado</h11>
        <div class='espaco_pequeno'></div>
    <h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply efeito-zoom" aria-hidden="true"></i> Voltar</a></h27>
 
    <div class="mt-4">

        <h11><i class="fa-solid fa-user"></i> <?php echo $nm_usuario; ?></h11>

        <textarea class="form form-control"></textarea>

        <div class="row" style="margin-left: 2px; width: 100%;">

            <div class="mt-3" style="width: 50%; background-color: #46a5d4; border: dashed 1px #46a5d4; text-align: center;">  
                
                <label style="color: white; padding-top: 10px;" class="btn btn-default btn-sm center-block btn-file">
    
                    <i class="fa fa-upload fa-1x" aria-hidden="true"></i>
                        Selecine um Arquivo!
                    <input name="arquivo" type="file" id="frm_arquivo" style="display: none;">
    
                </label>
    
            </div>
    
            <div style="float: left; width: 50%; text-align: right;">
        
                <a style="width: 160px;" class="mt-3 btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Enviar</a>
    
            </div>

        </div>


    </div>
    

<?php

    include 'rodape.php';

?>