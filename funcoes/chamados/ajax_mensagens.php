<?php

    session_start();	

    include '../../conexao.php';

    $id_chamado = $_GET['id'];

        // BUSCA TODAS AS MENSAGENS DO CHAMADO
        $cons_mensagens_chamado = "SELECT itch.DS_MENSAGEM,
        itch.CD_USUARIO_CADASTRO AS USUARIO_CADASTRO_MENSAGEM,
        ch.CD_USUARIO_CADASTRO AS USUARIO_CADASTRO_CHAMADO,
        ch.TP_STATUS,
        usu.NM_USUARIO,
        DATE_FORMAT(itch.HR_CADASTRO, '%d/%m/%Y') AS DATA_MENSAGEM,
        itch.ANEXO,
        TIME(itch.HR_CADASTRO) AS HORA_MENSAGEM
    FROM portal_comunica.CHAMADO ch
    INNER JOIN portal_comunica.ITCHAMADO itch
    ON ch.CD_CHAMADO = itch.CD_CHAMADO
    INNER JOIN portal_comunica.USUARIO usu
    ON itch.CD_USUARIO_CADASTRO = usu.CD_USUARIO
    WHERE ch.CD_CHAMADO = $id_chamado
    ORDER BY itch.HR_CADASTRO ASC";

$res = mysqli_query($conn, $cons_mensagens_chamado);

// PEGA A QUANTIDADE DE LINHAS NA CONSULTA DAS MENSAGENS ACIMA
$row_mensagens = mysqli_num_rows($res);

    echo '<div class="modal-footer" style="border: none !important; padding: 0px;">';
        
    echo '<div class="div_br"> </div>';

    echo '<div id="chat" style="width: 100%; margin: 0 auto; overflow: auto; max-height: 440px; padding: 10px;">';

        // LINHA HORIZONTAL
        echo '<div style="margin: 0 auto; width: 98%; height: 20px; clear: both; border-bottom: 1px solid #dee2e6; margin-top: -35px !important; margin-bottom: 10px; "></div><div style="clear: both;"> </div><div class="div_br"></div>';       

        // VERIFICA SE TEM ALGUMA MENSAGEM NO CHAT
        if ($row_mensagens > 0) {

            while ($row = mysqli_fetch_array($res)) {

                if ($row['USUARIO_CADASTRO_MENSAGEM'] == $_SESSION['cd_usu']) {

                    // CABEÇALHO DA MENSAGEM
                    echo '<div style="clear: both; width: 80%; height: 30px; font-size: 14px; text-align: center;
                    margin: 0 auto;"> '. $row['DATA_MENSAGEM'] .' '. $row['HORA_MENSAGEM'] .' - '. $row['NM_USUARIO'] .' <div style="background-color: rgba(70,165,212,0.2); width: 45%; margin: 0 auto; border-radius: 5px;"> SOLICITANTE </div></div>';
        
                    echo '<div class="div_br"> </div>';
                    echo '<div class="div_br"> </div>';
        
                    // MENSAGEM
                    echo '<img alt="teste_img" class="foto_usu" style="width:50px; height: 50px; float:right; margin-left: 10px; border-radius: 30px; border-color: #d6eaf8 !important; border: solid 2px; opacity: 30%;" src="img/outros/usuario.png">';
                    echo '<div class="mensagem_chat_usu">' . $row['DS_MENSAGEM'];

                    echo '</br><a target="_blank" style="color: #3185c1; font-size: 12px; text-decoration: none;" 
                    href="baixar_ftp.php?diretorio=' . $row['ANEXO'] . '">'. $row['ANEXO'] .'</a>';
                                        
                    echo '</div>';     

                } else {

                    // CABEÇALHO DA MENSAGEM
                    echo '<div style="clear: both; width: 80%; height: 30px; font-size: 14px; text-align: center;
                    margin: 0 auto;"> '. $row['DATA_MENSAGEM'] .' '. $row['HORA_MENSAGEM'] .' - '. $row['NM_USUARIO'] .'<div style="background-color: #ffd9ac; width: 45%; margin: 0 auto; border-radius: 5px;"> ATENDENTE </div></div>';
        
                    echo '<div class="div_br"> </div>';
                    echo '<div class="div_br"> </div>';
  
                    // MENSAGEM
                    echo '<img alt="teste_img" class="foto_usu" style="width:50px; height: 50px; float:left; margin-left: 10px; border-radius: 30px; border-color: #d6eaf8 !important; border: solid 2px; opacity: 30%;" src="img/outros/usuario.png">';
                    echo '<div style="float:left;" class="mensagem_chat_usu">' . $row['DS_MENSAGEM'];
                    
                    echo '</br><a target="_blank" style="color: #3185c1; font-size: 12px; text-decoration: none;" 
                    href="baixar_ftp.php?diretorio=' . $row['ANEXO'] . '">'. $row['ANEXO'] .'</a>';
                    
                    echo '</div>';   

                }

                // LINHA HORIZONTAL
                echo '<div style="margin: 0 auto; width: 98%; height: 20px; clear: both; border-bottom: 1px solid #dee2e6; margin-top: -35px !important; margin-bottom: 10px; "></div><div style="clear: both;"> </div><div class="div_br"></div>';  

            }

        } else {
            
            echo '<div style="text-align: center; padding: 55px 0px 55px 0px; color: #B3B4AF;">';

                echo 'Nenhuma mensagem no momento.';

            echo '</div>';

        }

    echo '</div>';

echo '</div>';

?>

<script>

    var chat = document.getElementById('chat');

    tamanho_chat = chat.scrollHeight;

    chat.scrollTo(0, tamanho_chat);

</script>