
<?php 

    include '../../conexao.php';

    //GRAFICO REALIZADOS POR MÊS
    $cons_meses = "";

    $resultado_cons_meses = oci_parse($conn_ora,$cons_meses);
?>

    <div style="max-width:70%; height: 400px; margin: 0 auto; text-align: center;">

        <div class="div_br"> </div>
        <div class="div_br"> </div>
        <h11><i class="fa-solid fa-chart-column efeito-zoom"></i> Realizados  </h11>
        <div class="div_br"> </div>

        <canvas id="myChart" style="width: 100%; height: 300px;"></canvas>

    </div>

<script>

    var ctx = document.getElementById("myChart").getContext("2d")

    var data = {

        labels: [
            
                <?php

                oci_execute($resultado_cons_meses);
                while($row_total =  oci_fetch_array($resultado_cons_meses)){
                echo "'".$row_total['PERIODO']."'".",";
                
                }?>

        ],

        datasets: [
            {
                label: "Realizados",
                backgroundColor: "#a2b3fc",
                borderColor: "#a2b3fc",
                data: [<?php 
                            oci_execute($resultado_cons_meses);
                            while($row_total =  oci_fetch_array($resultado_cons_meses)){
                                echo $row_total['QTD'].',';
                            }?>]
            },            
        ]
    }


    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
            legend: {
                position: 'top',
            },
            //title: {
            //    display: true,
            //    text: 'Consolidado Mensal'
            //}
            }
        },
    }); 


</script>