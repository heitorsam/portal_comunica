<?php

    $id_grupo = $_GET['idgrupo'];

    include '../conexao.php';

    // PEGA TODOS OS USUÁRIOS QUE PERTENCEM AO GRUPO ESPECÍFICO
    $cons_membros_grupo = "SELECT usu.NM_USUARIO
                           FROM portal_comunica.GRUPO_USUARIO grpusu
                           INNER JOIN portal_comunica.USUARIO usu
                               ON grpusu.CD_USUARIO = usu.CD_USUARIO
                           INNER JOIN portal_comunica.GRUPO grp
                               ON grpusu.CD_GRUPO = grp.CD_GRUPO
                           WHERE grp.CD_GRUPO = $id_grupo";

    $res = mysqli_query($conn, $cons_membros_grupo);

?>

<table class="table table-striped" style="text-align: center" >

    <thead>

        <th class="p-2" style="text-align: center; white-space: nowrap;">Nome</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Opções</th>

    </thead>

    <tbody>
        
        <?php
            // PERCORRE AS LINHAS DE TODOS OS MEMBROS DO GRUPO CLICADO
            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';

                    echo '<td class="align-middle">'. $row['NM_USUARIO'] .'</td>';
                    echo '<td>
                        <button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>      
                    </td>';
            
                echo '</tr>';

            }

        ?>


    </tbody>

</table>