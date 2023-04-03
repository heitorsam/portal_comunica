<?php

    include '../conexao.php';

    // CONSULTA DE USUÁRIOS CADASTRADOS
    $consulta = "SELECT usu.CD_USUARIO,
                        usu.NM_USUARIO,
                        emp.DS_EMPRESA
                FROM portal_comunica.USUARIO usu
                INNER JOIN portal_comunica.EMPRESA emp
                    ON usu.CD_EMPRESA = emp.CD_EMPRESA
                ORDER BY usu.CD_USUARIO ASC";

    // EXECUTA A CONSULTA E ARMAZENA NA VARIAVEL O RESULTADO
    $res = mysqli_query($conn ,$consulta);

?>

<table class="table table-striped" style="text-align: center" >

    <thead>

        <th class="p-2" style="text-align: center; white-space: nowrap;">Nome</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Empresa</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Opções</th>

    </thead>

    <tbody>
        
        <?php
            // PERCORRE AS LINHAS DE TODOS OS USUÁRIOS CADASTRADOS
            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';

                    echo '<td>'. $row['NM_USUARIO'] .'</td>';
                    echo '<td>'. $row['DS_EMPRESA'] .'</td>';
                    echo '<td>
                        <button onclick="ajax_modal_alterar_usuario('. $row['CD_USUARIO'] .')" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                        <button onclick="ajax_exclui_usuario('. $row['CD_USUARIO'] .')" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                    </td>';
            
                echo '</tr>';

            }

        ?>


    </tbody>


</table>