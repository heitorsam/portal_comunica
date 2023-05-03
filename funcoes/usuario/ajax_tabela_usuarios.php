<?php

    include '../../conexao.php';

    // CONSULTA DE USUÁRIOS CADASTRADOS
    $consulta = "SELECT usu.CD_USUARIO,
                        usu.NM_USUARIO,
                        emp.DS_EMPRESA,
                        usu.TP_USUARIO
                FROM portal_comunica.USUARIO usu
                INNER JOIN portal_comunica.EMPRESA emp
                    ON usu.CD_EMPRESA = emp.CD_EMPRESA
                ORDER BY usu.CD_USUARIO DESC";

    // EXECUTA A CONSULTA E ARMAZENA NA VARIAVEL O RESULTADO
    $res = mysqli_query($conn ,$consulta);

?>

<table class="table table-striped" style="text-align: center" >

    <thead>

        <th class="p-2" style="text-align: center; white-space: nowrap;">Código</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Nome</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Empresa</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Tipo de usuário</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Opções</th>

    </thead>

    <tbody>
        
        <?php
            // PERCORRE AS LINHAS DE TODOS OS USUÁRIOS CADASTRADOS
            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';

                    echo '<td class="align-middle">'. $row['CD_USUARIO'] .'</td>';
                    echo '<td class="align-middle">'. $row['NM_USUARIO'] .'</td>';
                    echo '<td class="align-middle">'. $row['DS_EMPRESA'] .'</td>';
                    echo '<td class="align-middle">'; 
                        if($row['TP_USUARIO'] == 'C'){ echo 'Comum'; } else
                        { echo 'Administrador'; }
                    echo '</td>';
                    echo '<td class="align-middle">
                        <button onclick="ajax_modal_alterar_usuario('. $row['CD_USUARIO'] .')" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                        <button onclick="ajax_exclui_usuario('. $row['CD_USUARIO'] .')" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                    </td>';
            
                echo '</tr>';

            }

        ?>


    </tbody>


</table>