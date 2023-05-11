<?php

    include '../../conexao.php';

    $id_empresa = $_GET['id'];

    $query_pegar_grupos_empresa = "SELECT grp.CD_GRUPO,
                                          grp.DS_GRUPO
                                   FROM bd_comunic.GRUPO grp
                                   WHERE grp.CD_EMPRESA = $id_empresa
                                   ORDER BY grp.DS_GRUPO ASC";

    $resp = mysqli_query($conn, $query_pegar_grupos_empresa);

    while ($row = mysqli_fetch_array($resp)) {

        echo '<option value="'. $row['CD_GRUPO'] .'">' . $row['DS_GRUPO'] . '</option>';

    };

?>