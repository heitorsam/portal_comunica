<?php

    session_start();

    include '../conexao.php';

    $cd_empresa_usuario_logado = $_SESSION['cd_empresa_usuario_logado'];

    // BUSCA APENAS OS GRUPOS QUE PERTENCEM A EMPRESA DO USUÁRIO QUE ESTÁ LOGADO
    $cons_buscar_grupos = "SELECT CD_GRUPO,
                                  DS_GRUPO
                           FROM portal_comunica.GRUPO grp
                           WHERE grp.CD_EMPRESA = $cd_empresa_usuario_logado";

    $res = mysqli_query($conn, $cons_buscar_grupos);

?>

<table class="table table-striped" style="text-align: center" >

    <thead>

        <th class="p-2" style="text-align: center; white-space: nowrap;">Código</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Grupo</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Opções</th>

    </thead>

    <tbody>
        
        <?php
            // PERCORRE AS LINHAS DE TODOS OS GRUPOS DO USUÁRIO LOGADO CADASTRADOS
            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';

                    echo '<td>'. $row['CD_GRUPO'] .'</td>';
                    echo '<td>'. $row['DS_GRUPO'] .'</td>';
                    echo '<td>
                        <button onclick="ajax_chamar_modal_edicao('. $row['CD_GRUPO'] .')" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                        <button onclick="ajax_chamar_modal_membro('. $row['CD_GRUPO'] .')" class="btn btn-primary"><i class="fa-solid fa-people-group"></i></button>
                        <button onclick="excluir_grupo('. $row['CD_GRUPO'] .')" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>      
                    </td>';
            
                echo '</tr>';

            }

        ?>


    </tbody>


</table>