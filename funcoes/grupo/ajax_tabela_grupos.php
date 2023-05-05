<?php

    session_start();

    include '../../conexao.php';

    $cd_empresa_usuario_logado = $_SESSION['cd_empresa_usuario_logado'];

    // BUSCA APENAS OS GRUPOS QUE PERTENCEM A EMPRESA DO USUÁRIO QUE ESTÁ LOGADO
    $cons_buscar_grupos = "SELECT CD_GRUPO,                           
                                DS_GRUPO,                           
                                (SELECT COUNT(CD_CHAMADO) 
                                FROM portal_comunica.CHAMADO ch
                                WHERE CD_GRUPO = grp.CD_GRUPO
                                    AND ch.TP_STATUS IN ('A', 'E')) AS QTD_CHAMADOS,
                                (SELECT COUNT(CD_USUARIO)
                                FROM portal_comunica.GRUPO_USUARIO grpusu
                                WHERE grpusu.CD_GRUPO = grp.CD_GRUPO) AS QTD_USUARIOS
                            FROM portal_comunica.GRUPO grp
                            WHERE grp.CD_EMPRESA = $cd_empresa_usuario_logado
                            ORDER BY CD_GRUPO DESC";

    $res = mysqli_query($conn, $cons_buscar_grupos);

?>

<table class="table table-striped" style="text-align: center" >

    <thead>

        <th class="p-2" style="text-align: center; white-space: nowrap;">Código</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Grupo</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Chamados</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Usuários</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Opções</th>

    </thead>

    <tbody>
        
        <?php
            // PERCORRE AS LINHAS DE TODOS OS GRUPOS DO USUÁRIO LOGADO CADASTRADOS
            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';

                    echo '<td class="align-middle">'. $row['CD_GRUPO'] .'</td>';
                    echo '<td class="align-middle">'. $row['DS_GRUPO'] .'</td>';
                    echo '<td class="align-middle">'. $row['QTD_CHAMADOS'] .'</td>';
                    echo '<td class="align-middle">'. $row['QTD_USUARIOS'] .'</td>';
                    echo '<td class="align-middle">
                        <button onclick="ajax_chamar_modal_edicao('. $row['CD_GRUPO'] .')" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                        <button onclick="ajax_chamar_modal_membro('. $row['CD_GRUPO'] .')" class="btn btn-primary"><i class="fa-solid fa-people-group"></i></button>';

                        if($row['QTD_CHAMADOS'] == 0 && $row['QTD_USUARIOS'] == 0){
        ?>

                            <button onclick="ajax_alert('Deseja excluir grupo?','excluir_grupo(<?php echo $row['CD_GRUPO']; ?>)')" class="btn btn-adm"><i class="fa-solid fa-trash-can"></i></button>

        <?php 
                        }else{

                            echo ' <button class="btn btn-secondary"><i class="fa-solid fa-trash-can"></i></button>';

                        }

                      
                    echo '</td>';
            
                echo '</tr>';

            }

        ?>


    </tbody>


</table>