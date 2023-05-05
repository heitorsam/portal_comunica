<?php

    include '../../conexao.php';

    $id_grupo = $_GET['idgrupo'];

    $cons_usuarios_grupo = "SELECT usu.NM_USUARIO,
                                   usu.CD_USUARIO,
                                    (SELECT COUNT(CD_CHAMADO)
                                    FROM portal_comunica.CHAMADO ch
                                    WHERE ch.CD_USUARIO_RESPONSAVEL = usu.CD_USUARIO
                                        AND ch.TP_STATUS = 'E'
                                        AND ch.CD_GRUPO = $id_grupo) AS QNTD_CHAMADOS
                                FROM portal_comunica.GRUPO_USUARIO grpusu
                                INNER JOIN portal_comunica.USUARIO usu
                                ON grpusu.CD_USUARIO = usu.CD_USUARIO
                                INNER JOIN portal_comunica.GRUPO grp
                                ON grpusu.CD_GRUPO = grp.CD_GRUPO
                                WHERE grp.CD_GRUPO = $id_grupo";

    $res = mysqli_query($conn, $cons_usuarios_grupo);

?>

<table class="table table-striped" style="text-align: center" >

    <thead>

        <th class="p-2" style="text-align: center; white-space: nowrap;">Nome</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Chamados</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Opções</th>

    </thead>

    <tbody>
        
        <?php
            // PERCORRE AS LINHAS DE TODOS OS USUÁRIOS DO GRUPO
            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';

                    echo '<td class="align-middle">'. $row['NM_USUARIO'] .'</td>';
                    echo '<td class="align-middle">'. $row['QNTD_CHAMADOS'] .'</td>';
                    echo '<td>';

                    if($row['QNTD_CHAMADOS'] == 0){
                        ?>
                        <button onclick="etapa_fecha_modal(<?php echo $row['CD_USUARIO']; ?>, <?php echo $id_grupo; ?>)" class="btn btn-adm"><i class="fa-solid fa-trash-can"></i></button>
                    <?php
                    } else {
                        echo ' <button class="btn btn-secondary"><i class="fa-solid fa-trash-can"></i></button>';
                    }
                    echo '</td>';
            
                echo '</tr>';

            }

        ?>


    </tbody>


</table>