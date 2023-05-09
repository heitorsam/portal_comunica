<?php

    session_start();

    include '../../conexao.php';

    $cd_usuario_logado = $_SESSION['cd_usu'];

    // PEGA AS VARIAVEIS VIA GET PARA UTILIZAR COMO FILTROS NAS CONSULTAS
    $periodo = $_GET['periodo'];
    $os = $_GET['os'];
    $usu = $_GET['usu'];
   
    $cons_chamados_abertos = "SELECT ch.*, usu.*, emp.*, 
                                DATE_FORMAT(ch.HR_CADASTRO,'%d/%m/%Y') AS HR_CADASTRO_FORMAT
                                FROM portal_comunica.CHAMADO ch
                                INNER JOIN portal_comunica.USUARIO usu
                                ON usu.CD_USUARIO = ch.CD_USUARIO_CADASTRO
                                INNER JOIN portal_comunica.EMPRESA emp
                                ON emp.CD_EMPRESA = ch.CD_EMPRESA
                                WHERE ch.CD_GRUPO IN (SELECT grpusu.CD_GRUPO
                                                FROM portal_comunica.GRUPO_USUARIO grpusu
                                                WHERE grpusu.CD_USUARIO = $cd_usuario_logado)
                                AND ch.TP_STATUS = 'A'
                                AND DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$periodo'";
    
    $cons_chamados_execucao = "SELECT ch.*, usu.*, emp.*, 
                                DATE_FORMAT(ch.HR_CADASTRO,'%d/%m/%Y') AS HR_CADASTRO_FORMAT
                                FROM portal_comunica.CHAMADO ch
                                INNER JOIN portal_comunica.USUARIO usu
                                ON usu.CD_USUARIO = ch.CD_USUARIO_CADASTRO
                                INNER JOIN portal_comunica.EMPRESA emp
                                ON emp.CD_EMPRESA = ch.CD_EMPRESA
                                WHERE ch.CD_GRUPO IN (SELECT grpusu.CD_GRUPO
                                            FROM portal_comunica.GRUPO_USUARIO grpusu
                                            WHERE grpusu.CD_USUARIO = $cd_usuario_logado)
                                AND ch.TP_STATUS = 'E'
                                AND DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$periodo'";
    
    $cons_chamados_concluidos = "SELECT ch.*, usu.*, emp.*, 
                                    DATE_FORMAT(ch.HR_CADASTRO,'%d/%m/%Y') AS HR_CADASTRO_FORMAT
                                    FROM portal_comunica.CHAMADO ch
                                    INNER JOIN portal_comunica.USUARIO usu
                                    ON usu.CD_USUARIO = ch.CD_USUARIO_CADASTRO
                                    INNER JOIN portal_comunica.EMPRESA emp
                                    ON emp.CD_EMPRESA = ch.CD_EMPRESA
                                    WHERE ch.CD_GRUPO IN (SELECT grpusu.CD_GRUPO
                                                FROM portal_comunica.GRUPO_USUARIO grpusu
                                                WHERE grpusu.CD_USUARIO = $cd_usuario_logado)
                                    AND ch.TP_STATUS = 'C'
                                    AND DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$periodo' ";


    if($os <> ''){

        $cons_chamados_abertos .= " AND ch.CD_CHAMADO = $os ";
        $cons_chamados_execucao .= " AND ch.CD_CHAMADO = $os ";
        $cons_chamados_concluidos .= " AND ch.CD_CHAMADO = $os ";

    }

    if($usu <> ''){

        //$cons_chamados_abertos .= " AND ch.CD_USUARIO_RESPONSAVEL = $usu ";
        $cons_chamados_execucao .= " AND ch.CD_USUARIO_RESPONSAVEL = $usu ";
        $cons_chamados_concluidos .= " AND ch.CD_USUARIO_RESPONSAVEL = $usu ";

    }

    $cons_chamados_abertos .= " ORDER BY ch.CD_CHAMADO DESC";
    $cons_chamados_execucao .= " ORDER BY ch.CD_CHAMADO DESC";
    $cons_chamados_concluidos .= " ORDER BY ch.CD_CHAMADO DESC";

    $res_abertos = mysqli_query($conn, $cons_chamados_abertos);
    $res_execucao = mysqli_query($conn, $cons_chamados_execucao);
    $res_concluidos = mysqli_query($conn, $cons_chamados_concluidos);

?>

<?php
    

    if (mysqli_num_rows($res_abertos) > 0) {

        echo '<div class="fnd_azul_dinamico"><i class="fa-regular fa-clock"></i> Pendentes</div>';

        echo '<div class="caixa_lista_chamados">';

            echo '<div class="row">';

                while ($row = mysqli_fetch_array($res_abertos)) {

                    echo '<div onclick="redirecionar_detalhe_chamado('. $row['CD_CHAMADO'] .')" class="col-12 col-md-3" style="background-color: rgba(0,0,0,0) !important; padding-top: 0px; padding-bottom: 0px;">';

                        echo '<div class="lista_home_itens_pend" style="cursor:pointer;">';

                            echo '<div class="mini_caixa_chamado"><b>OS ' . $row['CD_CHAMADO'] . '</b></div>';

                            echo '<div class="mini_caixa_chamado">' . $row['DS_EMPRESA'] . '</div>';  

                            echo '<div class="mini_caixa_chamado">' . $row['HR_CADASTRO_FORMAT'] . '</div>';                          

                            echo '<div style="clear: both;"></div>';

                            echo '<div class="mini_caixa_chamado" style="width: auto; word-wrap: break-word !important">' . $row['NM_USUARIO'] . '</div>';                                                    

                            echo '<div style="clear: both;"></div>';

                            echo '<div class="mini_caixa_chamado" style="width: auto; word-wrap: break-word; border: none;">' . $row['DS_CHAMADO'] . '</div>';
                            
                            echo '<div style="clear: both;"></div>';
                            
                            //echo '<a style="font-size: 12px; text-decoration: none; cursor: pointer; color: #6ba4e1;" class="fa-solid fa-magnifying-glass"></a>';

                        echo '</div>';
                            
                    echo '</div>';

                }

            echo '</div>';

        echo '</div>';

        echo '<div class="div_br"></div>';

    }

    if (mysqli_num_rows($res_execucao) > 0) {

        echo '<div class="fnd_azul_dinamico"><i class="fa-regular fa-clipboard"></i> Em execução</div>';

        echo '<div class="caixa_lista_chamados">';

            echo '<div class="row">';

                while ($row = mysqli_fetch_array($res_execucao)) {

                    echo '<div onclick="redirecionar_detalhe_chamado('. $row['CD_CHAMADO'] .')" class="col-12 col-md-3" style="background-color: rgba(0,0,0,0) !important; padding-top: 0px; padding-bottom: 0px;">';

                        echo '<div class="lista_home_itens" style="cursor:pointer;">';

                            echo '<div class="mini_caixa_chamado"><b>OS ' . $row['CD_CHAMADO'] . '</b></div>';

                            echo '<div class="mini_caixa_chamado">' . $row['DS_EMPRESA'] . '</div>';  

                            echo '<div class="mini_caixa_chamado">' . $row['HR_CADASTRO_FORMAT'] . '</div>';                          

                            echo '<div style="clear: both;"></div>';

                            echo '<div class="mini_caixa_chamado" style="width: auto; word-wrap: break-word !important">' . $row['NM_USUARIO'] . '</div>';                                                    

                            echo '<div style="clear: both;"></div>';

                            echo '<div class="mini_caixa_chamado" style="width: auto; word-wrap: break-word; border: none;">' . $row['DS_CHAMADO'] . '</div>';
                            
                            echo '<div style="clear: both;"></div>';
                            
                            //echo '<a style="font-size: 12px; text-decoration: none; cursor: pointer; color: #6ba4e1;" class="fa-solid fa-magnifying-glass"></a>';

                        echo '</div>';
                            
                    echo '</div>';

                }

            echo '</div>';

        echo '</div>';   

        echo '<div class="div_br"></div>';

    }

    if (mysqli_num_rows($res_concluidos) > 0) {
        
        echo '<div class="fnd_azul_dinamico"><i class="fa-solid fa-check"></i> Concluídos</div>';

        echo '<div class="caixa_lista_chamados">';

            echo '<div class="row">';

                while ($row = mysqli_fetch_array($res_concluidos)) {

                    echo '<div onclick="redirecionar_detalhe_chamado('. $row['CD_CHAMADO'] .')" class="col-12 col-md-3" style="background-color: rgba(0,0,0,0) !important; padding-top: 0px; padding-bottom: 0px;">';

                        echo '<div class="lista_home_itens_ok" style="cursor:pointer;">';

                            echo '<div class="mini_caixa_chamado"><b>OS ' . $row['CD_CHAMADO'] . '</b></div>';

                            echo '<div class="mini_caixa_chamado">' . $row['DS_EMPRESA'] . '</div>';  

                            echo '<div class="mini_caixa_chamado">' . $row['HR_CADASTRO_FORMAT'] . '</div>';                          

                            echo '<div style="clear: both;"></div>';

                            echo '<div class="mini_caixa_chamado" style="width: auto; word-wrap: break-word !important">' . $row['NM_USUARIO'] . '</div>';                                                    

                            echo '<div style="clear: both;"></div>';

                            echo '<div class="mini_caixa_chamado" style="width: auto; word-wrap: break-word; border: none;">' . $row['DS_CHAMADO'] . '</div>';
                            
                            echo '<div style="clear: both;"></div>';
                            
                            //echo '<a style="font-size: 12px; text-decoration: none; cursor: pointer; color: #6ba4e1;" class="fa-solid fa-magnifying-glass"></a>';

                        echo '</div>';
                            
                    echo '</div>';

                }

            echo '</div>';

        echo '</div>';

        echo '<div class="div_br"></div>';

    }
    
?>