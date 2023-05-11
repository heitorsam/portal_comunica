<?php

    session_start();

    $cd_usuario_logado = $_SESSION['cd_usu'];

    include '../../conexao.php';
    
    // $destino_foto = null;
    // $extensao = null;
    $descricao = $_POST['descricao'];
    $empresa = $_POST['empresa'];
    $grupo = $_POST['grupo'];
    $prioridade = $_POST['prioridade'];
    $data_prevista = $_POST['data_prevista'];
    $observacao = $_POST['observacao'];

    $query_insere_chamado = "INSERT INTO bd_comunic.CHAMADO (
                                                    CD_CHAMADO,
                                                    DS_CHAMADO,
                                                    CD_EMPRESA,
                                                    CD_GRUPO,
                                                    TP_PRIORIDADE,
                                                    DT_PREVISTA,
                                                    TP_STATUS,
                                                    OBS_MENSAGEM,
                                                    CD_USUARIO_CADASTRO,
                                                    HR_CADASTRO)
                                                    VALUES (
                                                    NULL,
                                                    '$descricao',
                                                    $empresa,
                                                    '$grupo',
                                                    '$prioridade',
                                                    '$data_prevista',
                                                    'A',
                                                    '$observacao',
                                                    $cd_usuario_logado,
                                                    NOW())";
    
    $valida = mysqli_query($conn, $query_insere_chamado);

    if(!$valida){

        //echo $query_insere_chamado;

        //SE ERRO 
        $var_result_final = 'Erro';

    }else {

        //DESCOBRINDO OS
        $query_descobre_os = "SELECT MAX(CD_CHAMADO) AS CD_OS
                              FROM bd_comunic.CHAMADO ch
                              WHERE ch.CD_USUARIO_CADASTRO = '$cd_usuario_logado'";
        
        $res_cd_os = mysqli_query($conn, $query_descobre_os);

        $row = mysqli_fetch_array($res_cd_os);

        $var_cd_os = $row['CD_OS'];

        //SE TUDO OK 
        $var_result_final = $var_cd_os;

        ///////////////////////
        //INICIO INSERCAO FTP//
        ///////////////////////

        //CONEXAO FTP
        include '../../conexao_ftp.php'; 

        //EXTENSOES PERMITIDAS
        $extensoes_autorizadas = array('.pdf');

        //PASTA FTP
        $caminho = 'anexo_chamado/';

        //TAMANHO ILIMITADO
        $limitar_tamanho = 0;

        //SOBESCREVER ARQUIVO
        $sobrescrever = 0; //0 - NAO 1 - SIM

        //VERIFICA SE ALGUM ARQUIVO FOI SELECIONADO
        if (empty($_FILES['arquivo']) ) {
            //echo "sucesso";
            //exit();
        }else{

            //DADOS DO ARQUIVO 
            $arquivo = $_FILES['arquivo'];
            $nome_arquivo = $arquivo['name'];
            $tamanho_arquivo = $arquivo['size'];
            $arquivo_temp = $arquivo['tmp_name'];
            $extensao_arquivo = strrchr( $nome_arquivo, '.' );
            $destino = $caminho . $nome_arquivo;

            //////////////
            //VALIDACOES//	
            //////////////

            if (!$sobrescrever && file_exists($destino) ) {
                //echo "Arquivo já existe!";
                //exit();
            }

            if ($limitar_tamanho && $limitar_tamanho < $tamanho_arquivo) {
                
                //echo "Arquivo excede tamanho limite!";
                //exit();
            }

            //if (!empty( $extensoes_autorizadas ) && ! in_array($extensao_arquivo,$extensoes_autorizadas) ) {
                //echo "Tipo de arquivo não permitido!";
                //exit();
            //}

            //CRIANDO NOVO DIRETORIO
            $diretorio_os = $caminho . $var_cd_os . '/';

            if (@ftp_mkdir($conexao_ftp, $diretorio_os)) {

                //echo 'Novo diretório criado com sucesso!';

            } else {

                //NAO FAZ NADA (OBS O @ ANTES DO NOME DA FUNCAO IGNORA OS ERROS)
                //echo 'Erro ao criar diretório!';

            }	

            //AJUSTE PARA ESSE PROJETO EM ESPECIFICO (PORTAL COMUNICA)
            $nome_arquivo = $var_cd_os . '_' . $nome_arquivo;

            //DESTINO FINAL DIRETORIO + ARQUIVO
            $diretorio_final = $diretorio_os . $nome_arquivo;
                
            //ENVIA O ARQUIVO PARA O FTP
            if (@ftp_put($conexao_ftp, $diretorio_final , $arquivo_temp, FTP_BINARY)) {

                //echo "Arquivo enviado com sucesso!";
                    
                //RENOMEANDO ARQUIVO	
                $renomear_diretorio_final = $diretorio_os . $nome_arquivo;	
                ftp_rename($conexao_ftp, $diretorio_final, $renomear_diretorio_final);

                //ATUALIZA CHAMADO COM DADOS DO ANEXO
                $query_update_chamado = "UPDATE bd_comunic.CHAMADO ch
                                         SET ch.ANEXO = '$diretorio_final',
                                             ch.EXT = '$extensao_arquivo'
                                        WHERE ch.CD_CHAMADO = '$var_cd_os'";

                mysqli_query($conn, $query_update_chamado); 
                                            
            } else {
                

                //SE ERRO 
                //$var_result_final = 'ERRO';

                //echo "Erro ao enviar o arquivo!";		
                //echo 'Erro ao enviar arquivo!'; echo "</br></br>";
                //echo  $conexao_ftp; echo "</br></br>";
                //echo  $destino; echo "</br></br>";
                //echo  $arquivo_temp; 
            }

            //ENCERRA CONEXAO FTP
            ftp_close($conexao_ftp);

            ////////////////////
            //FIM INSERCAO FTP//
            ////////////////////

        }

    }

    echo $var_result_final;

?>