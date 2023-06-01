
<?php 

    include '../../conexao.php';

    //COLETANDO DADOS VIA GET
    $var_usuario_logado = $_GET['usu'];
    $var_periodo = $_GET['periodo'];  


    ///////////////////////////////////////////////
    //SOLICITACOES
    ///////////////////////////////////////////////
    
    //GRAFICO GERAL POR PRESTADOR
    $cons_geral_sol = "SELECT DATE_FORMAT(ch.HR_CADASTRO,'%m/%Y') AS PERIODO, 
                   COUNT(ch.CD_CHAMADO) AS QTD_TODOS,

                   (SELECT COUNT(ch.CD_CHAMADO) AS QTD_ABERTOS
                   FROM bd_comunic.CHAMADO ch 
                   WHERE DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$var_periodo' 
                   AND ch.CD_USUARIO_CADASTRO = $var_usuario_logado
                   AND ch.TP_STATUS = 'A') AS QTD_ABERTOS,                  
                                      
                   (SELECT COUNT(ch.CD_CHAMADO) AS QTD_EM_EXECUCAO
                   FROM bd_comunic.CHAMADO ch 
                   WHERE DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$var_periodo' 
                   AND ch.CD_USUARIO_CADASTRO = $var_usuario_logado
                   AND ch.TP_STATUS = 'E') AS QTD_EM_EXECUCAO,                   
                   
                   (SELECT COUNT(ch.CD_CHAMADO) AS QTD_CONCLUIDOS
                   FROM bd_comunic.CHAMADO ch 
                   WHERE DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$var_periodo' 
                   AND ch.CD_USUARIO_CADASTRO = $var_usuario_logado
                   AND ch.TP_STATUS = 'C') AS QTD_CONCLUIDOS

                   FROM bd_comunic.CHAMADO ch 
                   WHERE DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$var_periodo' 
                   AND ch.CD_USUARIO_CADASTRO = $var_usuario_logado
                   GROUP BY DATE_FORMAT(ch.HR_CADASTRO,'%m/%Y')";

    //echo $cons_geral_sol;

?>

    <div style="max-width:70%; height: 400px; margin: 0 auto; text-align: center;">

        <h11><i class="fa-solid fa-chart-column efeito-zoom"></i> Solicitados </h11>
        <div class="div_br"> </div>

        <canvas id="myChart" style="width: 100%; height: 300px;"></canvas>

    </div>

<script>

    var ctx = document.getElementById("myChart").getContext("2d")

    var data = {

        labels: [
            
                <?php

                $result_cons_geral_sol = mysqli_query($conn, $cons_geral_sol);
                while($row_cons_geral_sol = mysqli_fetch_array($result_cons_geral_sol)){
                echo "'".$row_cons_geral_sol['PERIODO']."'".",";
                
                }?>

        ],

        datasets: [
            {
                label: "Pendentes",
                backgroundColor: "#f5b699",
                borderColor: "#f5b699",
                data: [<?php 
                            $result_cons_geral_sol = mysqli_query($conn, $cons_geral_sol);
                            while($row_cons_geral_sol = mysqli_fetch_array($result_cons_geral_sol)){
                                echo $row_cons_geral_sol['QTD_ABERTOS'].',';
                            }?>]
            },   
            
            {
                label: "Em Execução",
                backgroundColor: "#a2b3fc",
                borderColor: "#a2b3fc",
                data: [<?php 
                            $result_cons_geral_sol = mysqli_query($conn, $cons_geral_sol);
                            while($row_cons_geral_sol = mysqli_fetch_array($result_cons_geral_sol)){
                                echo $row_cons_geral_sol['QTD_EM_EXECUCAO'].',';
                            }?>]
            },   

            {
                label: "Finalizados",
                backgroundColor: "#9deddc",
                borderColor: "#9deddc",
                data: [<?php 
                            $result_cons_geral_sol = mysqli_query($conn, $cons_geral_sol);
                            while($row_cons_geral_sol = mysqli_fetch_array($result_cons_geral_sol)){
                                echo $row_cons_geral_sol['QTD_CONCLUIDOS'].',';
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

<?php

    ///////////////////////////////////////////////
    //
    ///////////////////////////////////////////////
    
    //GRAFICO GERAL POR PRESTADOR
    $cons_geral_meus = "SELECT DATE_FORMAT(ch.HR_CADASTRO,'%m/%Y') AS PERIODO, 
                   COUNT(ch.CD_CHAMADO) AS QTD_ABERTOS,
                   
                   (SELECT COUNT(ch.CD_CHAMADO) AS QTD_EM_EXECUCAO
                   FROM bd_comunic.CHAMADO ch 
                   WHERE DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$var_periodo' 
                   AND ch.CD_USUARIO_RESPONSAVEL = $var_usuario_logado
                   AND ch.TP_STATUS = 'E') AS QTD_EM_EXECUCAO,                   
                   
                   (SELECT COUNT(ch.CD_CHAMADO) AS QTD_CONCLUIDOS
                   FROM bd_comunic.CHAMADO ch 
                   WHERE DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$var_periodo' 
                   AND ch.CD_USUARIO_RESPONSAVEL = $var_usuario_logado
                   AND ch.TP_STATUS = 'C') AS QTD_CONCLUIDOS

                   FROM bd_comunic.CHAMADO ch 
                   WHERE DATE_FORMAT(ch.HR_CADASTRO,'%Y-%m') = '$var_periodo' 
                   AND ch.CD_USUARIO_RESPONSAVEL = $var_usuario_logado
                   AND ch.TP_STATUS IN ('C','E')
                   GROUP BY DATE_FORMAT(ch.HR_CADASTRO,'%m/%Y')";

    //echo $cons_geral_meus;

?>

    <div style="max-width:70%; height: 400px; margin: 0 auto; text-align: center;">

        <h11><i class="fa-solid fa-chart-column efeito-zoom"></i>  Recebidos </h11>
        <div class="div_br"> </div>

        <canvas id="myChart2" style="width: 100%; height: 300px;"></canvas>

    </div>

<script>

    var ctx = document.getElementById("myChart2").getContext("2d")

    var data = {

        labels: [
            
                <?php

                $result_cons_geral_meus = mysqli_query($conn, $cons_geral_meus);
                while($row_cons_geral_meus = mysqli_fetch_array($result_cons_geral_meus)){
                echo "'".$row_cons_geral_meus['PERIODO']."'".",";
                
                }?>

        ],

        datasets: [
            {
                label: "Aceitos",
                backgroundColor: "#f5b699",
                borderColor: "#f5b699",
                data: [<?php 
                            $result_cons_geral_meus = mysqli_query($conn, $cons_geral_meus);
                            while($row_cons_geral_meus = mysqli_fetch_array($result_cons_geral_meus)){
                                echo $row_cons_geral_meus['QTD_ABERTOS'].',';
                            }?>]
            },   
            
            {
                label: "Em Execução",
                backgroundColor: "#a2b3fc",
                borderColor: "#a2b3fc",
                data: [<?php 
                            $result_cons_geral_meus = mysqli_query($conn, $cons_geral_meus);
                            while($row_cons_geral_meus = mysqli_fetch_array($result_cons_geral_meus)){
                                echo $row_cons_geral_meus['QTD_EM_EXECUCAO'].',';
                            }?>]
            },   

            {
                label: "Finalizados",
                backgroundColor: "#9deddc",
                borderColor: "#9deddc",
                data: [<?php 
                            $result_cons_geral_meus = mysqli_query($conn, $cons_geral_meus);
                            while($row_cons_geral_meus = mysqli_fetch_array($result_cons_geral_meus)){
                                echo $row_cons_geral_meus['QTD_CONCLUIDOS'].',';
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