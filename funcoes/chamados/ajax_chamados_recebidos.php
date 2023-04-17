<?php

    session_start();

    include '../../conexao.php';

    $cd_usuario_logado = $_SESSION['cd_usu'];

    $cons_chamados_abertos = "SELECT ch.CD_CHAMADO,
                                     ch.DS_CHAMADO
                                FROM portal_comunica.CHAMADO ch
                                WHERE ch.CD_GRUPO IN (SELECT grpusu.CD_GRUPO
                                                FROM portal_comunica.GRUPO_USUARIO grpusu
                                                WHERE grpusu.CD_USUARIO = $cd_usuario_logado)
                                AND ch.TP_STATUS = 'A'";
    
    $cons_chamados_execucao = "SELECT ch.CD_CHAMADO,
                                      ch.DS_CHAMADO
                                FROM portal_comunica.CHAMADO ch
                                WHERE ch.CD_GRUPO IN (SELECT grpusu.CD_GRUPO
                                            FROM portal_comunica.GRUPO_USUARIO grpusu
                                            WHERE grpusu.CD_USUARIO = $cd_usuario_logado)
                                AND ch.TP_STATUS = 'E'";
    
    $cons_chamados_concluidos = "SELECT ch.CD_CHAMADO,
                                        ch.DS_CHAMADO
                                    FROM portal_comunica.CHAMADO ch
                                    WHERE ch.CD_GRUPO IN (SELECT grpusu.CD_GRUPO
                                                FROM portal_comunica.GRUPO_USUARIO grpusu
                                                WHERE grpusu.CD_USUARIO = $cd_usuario_logado)
                                    AND ch.TP_STATUS = 'C'";
    
    $res_abertos = mysqli_query($conn, $cons_chamados_abertos);
    $res_execucao = mysqli_query($conn, $cons_chamados_execucao);
    $res_concluidos = mysqli_query($conn, $cons_chamados_concluidos);

?>

<?php

    if (mysqli_num_rows($res_abertos) > 0) {

        echo '<div class="fnd_azul"><i class="fa-regular fa-clipboard"></i> Pendentes</div>';

        echo '<div class="div_br"></div>';

        echo '<div class="row">';

            while ($row = mysqli_fetch_array($res_abertos)) {

                echo '<div onclick="abrir_modal_chamado('. $row['CD_CHAMADO'] .')" class="col-12 col-md-4" style="background-color: #f9f9f9 !important; padding-top: 0px; padding-bottom: 0px;">';

                    echo '<div class="lista_home_itens" style="cursor:pointer;">';

                        echo '<b> Código: '. $row['CD_CHAMADO'] .' </b>';
                        echo '<a style="font-size: 12px; text-decoration: none; cursor: pointer; color: #6ba4e1;" class="fa-solid fa-magnifying-glass"></a>';
                        echo '<br> '. $row['DS_CHAMADO'] .'';

                    echo '</div>';
                        
                echo '</div>';

            }

        echo '</div>';

        echo '<div class="div_br"></div>';

    }

    if (mysqli_num_rows($res_execucao) > 0) {

        echo '<div class="fnd_azul"><i class="fa-regular fa-clipboard"></i> Em execução</div>';

        echo '<div class="div_br"></div>';

        echo '<div class="row">';

            while ($row = mysqli_fetch_array($res_execucao)) {

                echo '<div onclick="abrir_modal_chamado('. $row['CD_CHAMADO'] .')" class="col-12 col-md-4" style="background-color: #f9f9f9 !important; padding-top: 0px; padding-bottom: 0px;">';

                    echo '<div class="lista_home_itens" style="cursor:pointer;">';

                        echo '<b> Código: '. $row['CD_CHAMADO'] .' </b>';
                        echo '<a style="font-size: 12px; text-decoration: none; cursor: pointer; color: #6ba4e1;" class="fa-solid fa-magnifying-glass"></a>';
                        echo '<br> '. $row['DS_CHAMADO'] .'';

                    echo '</div>';
                        
                echo '</div>';

            }

        echo '</div>';

        echo '<div class="div_br"></div>';

    }

    if (mysqli_num_rows($res_concluidos) > 0) {
        
        echo '<div class="fnd_azul"><i class="fa-regular fa-clipboard"></i> Concluídos</div>';

        echo '<div class="div_br"></div>';

        echo '<div class="row">';

            while ($row = mysqli_fetch_array($res_concluidos)) {

                echo '<div onclick="abrir_modal_chamado('. $row['CD_CHAMADO'] .')" class="col-12 col-md-4" style="background-color: #f9f9f9 !important; padding-top: 0px; padding-bottom: 0px;">';

                    echo '<div class="lista_home_itens" style="cursor:pointer;">';

                        echo '<b> Código: '. $row['CD_CHAMADO'] .' </b>';
                        echo '<a style="font-size: 12px; text-decoration: none; cursor: pointer; color: #6ba4e1;" class="fa-solid fa-magnifying-glass"></a>';
                        echo '<br> '. $row['DS_CHAMADO'] .'';

                    echo '</div>';
                        
                echo '</div>';

            }

        echo '</div>';

        echo '<div class="div_br"></div>';

    }
    
?>