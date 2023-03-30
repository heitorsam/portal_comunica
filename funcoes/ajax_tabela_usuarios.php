<?php

    include '../conexao.php';

    $consulta = "SELECT usu.NM_USUARIO,
                        emp.DS_EMPRESA
                FROM portal_comunica.USUARIO usu
                INNER JOIN portal_comunica.EMPRESA emp
                    ON usu.CD_EMPRESA = emp.CD_EMPRESA";

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

            while ($row = mysqli_fetch_array($res)) {

                echo '<tr style="text-align: center">';
                      
                    echo '<td>'. $row['NM_USUARIO'] .'</td>';
                    echo '<td>'. $row['DS_EMPRESA'] .'</td>';
                    echo '<td>
                        <button class="btn btn-primary"><i class="fa-solid fa-pencil"></i></button>
                        <button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                    </td>';
            
                echo '</tr>';

            }

        ?>


    </tbody>


</table>