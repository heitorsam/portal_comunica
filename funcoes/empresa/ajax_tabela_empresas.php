<?php

    include '../../conexao.php';

    $consulta_empresas = "SELECT CD_EMPRESA,
                                 DS_EMPRESA                                 
                          FROM portal_comunica.EMPRESA;";
    
    $res = mysqli_query($conn, $consulta_empresas);

?>

<div class="div_br"></div>

<table  class="table table-striped" style="text-align: center">

    <thead>

        <th class="p-2" style="text-align: center; white-space: nowrap;">Código</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Empresa</th>
        <th class="p-2" style="text-align: center; white-space: nowrap;">Opções</th>

    </thead>

    <tbody>

        <?php

            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';

                    echo '<td class="align-middle">'. $row['CD_EMPRESA'] .'</td>';
                    echo '<td class="align-middle">'. $row['DS_EMPRESA'] .'</td>';
                    echo '<td class="align-middle">
                            <button onclick="ajax_modal_alterar_empresa('. $row['CD_EMPRESA'] .')" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                            <button onclick="ajax_exclui_empresa('. $row['CD_EMPRESA'] .')" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </td>';

                echo '</tr>';

            };

        ?>

    </tbody>

</table>