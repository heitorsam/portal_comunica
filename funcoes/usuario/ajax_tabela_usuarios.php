<?php

    include '../../conexao.php';

    // CONSULTA DE USUÁRIOS CADASTRADOS
    $consulta = "SELECT usu.CD_USUARIO,
                        usu.NM_USUARIO,
                        emp.DS_EMPRESA,
                        usu.TP_USUARIO,
                        (SELECT COUNT(CD_CHAMADO)
                        FROM portal_comunica.CHAMADO ch
                        WHERE ch.CD_USUARIO_CADASTRO = usu.CD_USUARIO
                            AND ch.TP_STATUS IN ('A', 'E')) AS QNTD_CHAMADOS_ABERTOS,
                        (SELECT COUNT(CD_CHAMADO)
                        FROM portal_comunica.CHAMADO ch
                        WHERE ch.CD_USUARIO_RESPONSAVEL = usu.CD_USUARIO
                            AND ch.TP_STATUS = 'E') AS QNTD_CHAMADOS_RECEBIDOS,
                        (SELECT COUNT(CD_GRUPO_USUARIO)
                        FROM portal_comunica.GRUPO_USUARIO grpusu
                        WHERE grpusu.CD_USUARIO = usu.CD_USUARIO) AS QNTD_GRUPOS
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
        <th class="p-2" style="text-align: center; white-space: nowrap;">Chamados Abertos</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Chamados Recebidos</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Grupos vinculados</th>
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
                    echo '<td class="align-middle">'. $row['QNTD_CHAMADOS_ABERTOS'] .'</td>';
                    echo '<td class="align-middle">'. $row['QNTD_CHAMADOS_RECEBIDOS'] .'</td>';
                    echo '<td class="align-middle">'. $row['QNTD_GRUPOS'] .'</td>';
                    echo '<td class="align-middle">
                        <button onclick="ajax_modal_alterar_usuario('. $row['CD_USUARIO'] .')" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>';
                        if ($row['QNTD_CHAMADOS_ABERTOS'] == 0 && $row['QNTD_CHAMADOS_RECEBIDOS'] == 0 && $row['QNTD_GRUPOS'] == 0) {

                            ?>

                        <button onclick="ajax_alert('Deseja excluir usuário?','ajax_exclui_usuario(<?php echo $row['CD_USUARIO']; ?>)')" class="btn btn-adm"><i class="fa-solid fa-trash-can"></i></button>

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