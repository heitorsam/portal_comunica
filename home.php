<?php 
    //CABECALHO
    include 'cabecalho.php';

    //ACESSO ADM
    //include 'acesso_restrito_adm.php';
?>

    <div class="div_br"> </div>

    <!--MENSAGENS-->
    <?php
        include 'js/mensagens.php';
        include 'js/mensagens_usuario.php';
    ?>

    <h11><i class="fa-solid fa-list efeito-zoom" aria-hidden="true"></i> Portal Relatorios</h11>

    <div class="div_br"> </div>

    <!--RELATORIOS-->

        <?php if(@$_SESSION['SN_CUSTOS'] == 'S'){?>

        <a href="relatorio_custos.php" class="botao_home" type="submit"><i class="fa-solid fa-coins"></i>  Custos - 429</a></td></tr>
        <span class="espaco_pequeno"></span>

        <?php } ?>

        <?php if(@$_SESSION['SN_SEPSE'] == 'S'){?>

        <a href="relatorio_sepse.php" class="botao_home" type="submit"><i class="fa-solid fa-bacteria"></i>  Sepse - 430</a></td></tr>
        <span class="espaco_pequeno"></span>
              
        <?php } ?>

        <?php if(@$_SESSION['SN_REPASSE'] == 'S'){?>

        <a href="relatorio_repasse.php" class="botao_home" type="submit"><i class="fa-solid fa-file-circle-check"></i> Repasse</a></td></tr>
        <span class="espaco_pequeno"></span>
              
        <?php } ?>

        <?php if(@$_SESSION['SN_SAE'] == 'S'){?>

        <a href="relatorio_sae.php" class="botao_home" type="submit"><i class="fa-solid fa-clipboard-question"></i> SAE - Uis</a></td></tr>
        <span class="espaco_pequeno"></span>

        <?php } ?>

        <?php if(@$_SESSION['SN_RX'] == 'S'){?>

        <a href="relatorio_exa_realizados.php" class="botao_home" type="submit"><i class="fa-solid fa-prescription"></i> Exames Relizados</a></td></tr>
        <span class="espaco_pequeno"></span>
        
        <?php } ?>

        <?php if(@$_SESSION['SN_PROC_SUS'] == 'S'){?>

        <a href="relatorio_procedimento_sus.php" class="botao_home" type="submit"><i class="fa-solid fa-file-medical"></i> Procedimento SUS</a></td></tr>
        <span class="espaco_pequeno"></span>

        <?php } ?>

        
        <?php if(@$_SESSION['SN_ENDOSCOPIA'] == 'S'){?>

        <a href="relatorio_endoscopia.php" class="botao_home" type="submit"><i class="fa-solid fa-file-medical"></i> Endoscopia</a></td></tr>
        <span class="espaco_pequeno"></span>

        <?php } ?>

        <?php if(@$_SESSION['SN_MARCADORES_CIRURGICOS'] == 'S'){?>

        <a href="relatorio_marcadores_cirurgicos.php" class="botao_home" type="submit"><i class="fa-solid fa-file-medical"></i> Marcadores Cirúrgicos</a></td></tr>
        <span class="espaco_pequeno"></span>

        <?php } ?>


    <div class='espaco_vertical_medio'></div>

<?php
    //RODAPE
    include 'rodape.php';
?>
