<?php

    include '../../conexao.php';

    $id_grupo = $_GET['idgrupo'];

    $cons_usuarios_grupo = "SELECT usu.CD_USUARIO,
                                   usu.NM_USUARIO
                            FROM portal_comunica.GRUPO_USUARIO grpusu
                            INNER JOIN portal_comunica.USUARIO usu
                                ON usu.CD_USUARIO = grpusu.CD_USUARIO
                            WHERE grpusu.CD_GRUPO = $id_grupo";

    $res = mysqli_query($conn, $cons_usuarios_grupo);

?>

<table class="table table-striped" style="text-align: center" >

    <thead>

        <th class="p-2" style="text-align: center; white-space: nowrap;">Nome</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Opções</th>

    </thead>

    <tbody>
        
        <?php
            // PERCORRE AS LINHAS DE TODOS OS USUÁRIOS DO GRUPO
            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';

                    echo '<td>'. $row['NM_USUARIO'] .'</td>';
                    echo '<td>
                        <button onclick="excluir_usuario_grupo('. $row['CD_USUARIO'] .', ' .$id_grupo .')" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                    </td>';
            
                echo '</tr>';

            }

        ?>


    </tbody>


</table>