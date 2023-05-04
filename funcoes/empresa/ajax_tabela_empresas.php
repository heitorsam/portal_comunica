<?php

    include '../../conexao.php';

    $consulta_empresas = "SELECT emp.CD_EMPRESA,
                          emp.DS_EMPRESA,
                          (SELECT COUNT(CD_GRUPO) FROM portal_comunica.GRUPO WHERE CD_EMPRESA = emp.CD_EMPRESA) AS QTD_GRUPO,       
                          (SELECT COUNT(CD_CHAMADO) FROM portal_comunica.CHAMADO WHERE CD_EMPRESA = emp.CD_EMPRESA) AS QTD_CHAMADO,                                  
                          (SELECT COUNT(CD_USUARIO) FROM portal_comunica.USUARIO WHERE CD_EMPRESA = emp.CD_EMPRESA) AS QTD_USUARIO       
                          FROM portal_comunica.EMPRESA emp
                          ORDER BY emp.CD_EMPRESA DESC";
    
    $res = mysqli_query($conn, $consulta_empresas);

?>

<div class="div_br"></div>

<table  class="table table-striped" style="text-align: center">

    <thead>

        <th class="p-2" style="text-align: center; white-space: nowrap;">Código</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Empresa</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Grupos</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Usuários</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Chamados</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Opções</th>

    </thead>

    <tbody>

        <?php

            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';

                    echo '<td class="align-middle">'. $row['CD_EMPRESA'] .'</td>';
                    echo '<td class="align-middle">'. $row['DS_EMPRESA'] .'</td>';
                    echo '<td class="align-middle">'. $row['QTD_GRUPO'] .'</td>';
                    echo '<td class="align-middle">'. $row['QTD_USUARIO'] .'</td>';
                    echo '<td class="align-middle">'. $row['QTD_CHAMADO'] .'</td>';
                
                    echo '<td class="align-middle">
                            <button onclick="ajax_modal_alterar_empresa('. $row['CD_EMPRESA'] .')" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>';
                    if($row['QTD_GRUPO'] == 0 && $row['QTD_USUARIO'] == 0 && $row['QTD_CHAMADO'] == 0){

                        ?>

                            <button onclick="ajax_alert('Deseja excluir a empresa?','ajax_exclui_empresa(<?php echo $row['CD_EMPRESA']; ?>)')" class="btn btn-adm"><i class="fa-solid fa-trash-can"></i></button>


                        <?php


                    }else{

                        echo ' <button class="btn btn-secondary"><i class="fa-solid fa-trash-can"></i></button>';

                    }
                    
                    echo '</td>';

                echo '</tr>';

            };

        ?>

    </tbody>

</table>