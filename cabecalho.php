<?php
session_start();	
    //PHP GERAL

    //PAGINA ATUAL
    $_SESSION['pagina_acesso'] = substr($_SERVER["PHP_SELF"],1,30);

    //CORRIGE PROBLEMAS DE HEADER (LIMPAR O BUFFER)
    ob_start();

    //VARIAVEIS NOME
    @$nome = $_SESSION['usuarioNome'];
    @$pri_nome = substr($nome, 0, strpos($nome, ' '));

    //ACESSO RESTRITO
    //include 'acesso_restrito.php';    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="img/logo/icone_santa_casa_sjc_colorido.png">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Portal Relatórios</title>
    <!--CSS-->
    <?php 
        include 'css/style.php';
        include 'css/style_mobile.php';
    ?>

    </script>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <!--<script src="https://kit.fontawesome.com/302b2cb8e2.js" crossorigin="anonymous"></script>-->
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">

    <!--GRAFICOS CHART JS -->
    <script src="js/chartjs_3_7_1.min"> </script>

</head>
<body>
    <header>    

        <nav class="navbar navbar-expand-md navbar-dark bg-color">
            <a class="navbar-brand" href="home.php">
                <img src="img/logo/icone_santa_casa_sjc_branco.png" height="28px" width="28px" class="d-inline-block align-top efeito-zoom" alt="Santa Casa de São José dos Campos">
                <h10>Portal Relatórios</h10>
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample06" aria-controls="navbarsExample06" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarsExample06">
                <ul class="navbar-nav">          
                <li class="nav-item active">
                    <a class="nav-link" href="#"> <span class="sr-only">(current)</span></a>
                </li>
                <div class="menu_azul_claro">
                    <li class="nav-item">
                        <h10><a class="nav-link" onclick="ajax_redireciona_easter_egg('1')"><i class="fa-regular fa-circle-question efeito-zoom" aria-hidden="true"></i> Faq</a></h10>
                    </li>
                </div>
                <div class="menu_preto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="conta_click('2')">
                        <i class="fa fa-bars" aria-hidden="true"></i> Menu</a></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown06">

                        <!--MENU-->      

                        <?php if($_SESSION['SN_CUSTOS'] == 'S'){?>

                            <a class="dropdown-item" href="custos.php"><i class="fas fa-file-import"></i>  Custos</a>
                        
                        <?php } ?>

                        <?php if($_SESSION['SN_SEPSE'] == 'S'){?>

                            <a class="dropdown-item" href="relatorio_sepse.php"><i class="fas fa-file-import"></i>  Sepse</a>  

                        <?php } ?>

                        <?php if($_SESSION['SN_REPASSE'] == 'S'){?>

                            <a class="dropdown-item" href="relatorio_repasse.php"><i class="fas fa-file-import"></i>  Repasse</a>  

                        <?php } ?>

                        <?php if($_SESSION['SN_SAE'] == 'S'){?>

                            <a class="dropdown-item" href="relatorio_sae.php"><i class="fas fa-file-import"></i>  SAE</a>  
                        
                        <?php } ?>

                        <?php if($_SESSION['SN_RX'] == 'S'){?>

                            <a class="dropdown-item" href="relatorio_exa_realizados.php"><i class="fas fa-file-import"></i>  Exames Realizados</a>  
                        
                        <?php } ?>

                        <?php if($_SESSION['SN_PROC_SUS'] == 'S'){?>

                            <a class="dropdown-item" href="relatorio_procedimento_sus.php"><i class="fas fa-file-import"></i>  Procedimento SUS</a>  
                        
                        <?php } ?>

                        </div>
                    </li>
                </div>
                </li>
                <div class="menu_perfil">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-regular fa-circle-user" aria-hidden="true"></i> <?php echo $pri_nome ?></a></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown06">
                        <a class="dropdown-item" href="sair.php"> <i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
                        </div>
                    </li>
                <div class="menu_vermelho">
                </ul>
            </div>
        </nav>

    </header>
    <main>

        <div class="conteudo">
            <div class="container">