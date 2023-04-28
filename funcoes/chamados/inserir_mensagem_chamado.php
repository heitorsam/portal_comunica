<?php

    session_start();

    include '../../conexao.php';

    $cd_usuario_logado = $_SESSION['cd_usu'];
    $mensagem = $_POST['mensagem'];
    $id_chamado = $_POST['id_chamado'];

    $insert_mensagem_chamado = "INSERT INTO portal_comunica.ITCHAMADO (CD_CHAMADO,
                                                                        DS_MENSAGEM,
                                                                        ANEXO,
                                                                        EXT,
                                                                        CD_USUARIO_CADASTRO,
                                                                        HR_CADASTRO)
                                                                        VALUES 
                                                                        ($id_chamado,
                                                                        '$mensagem',
                                                                        NULL,
                                                                        NULL,
                                                                        $cd_usuario_logado,
                                                                        NOW())";

    $valida = mysqli_query($conn, $insert_mensagem_chamado);

    if(!$valida){

        echo 'Erro na consulta';

    } else {

        //DESCOBRINDO OS
        $query_descobre_itchamado = "SELECT MAX(CD_ITCHAMADO) AS CD_ITCHAMADO
                            FROM portal_comunica.ITCHAMADO itch
                            WHERE itch.CD_USUARIO_CADASTRO = '$cd_usuario_logado'";

        $res_cd_itchamado = mysqli_query($conn, $query_descobre_itchamado);

        $row = mysqli_fetch_array($res_cd_itchamado);

        $var_cd_itchamado = $row['CD_ITCHAMADO'];

        ///////////////////////
        //INICIO INSERCAO FTP//
        ///////////////////////
    
        //CONEXAO FTP
        include '../../conexao_ftp.php';
    
        //EXTENSOES PERMITIDAS
        $extensoes_autorizadas = array('.pdf');
    
        //PASTA FTP
        $caminho = 'anexo_chamado/'. $id_chamado . '/';
    
        //TAMANHO ILIMITADO
        $limitar_tamanho = 0;
    
        //SOBESCREVER ARQUIVO
        $sobrescrever = 0; //0 - NAO 1 - SIM
    
        //VERIFICA SE ALGUM ARQUIVO FOI SELECIONADO
        if (!isset( $_FILES['arquivo_mensagem']) ) {
            echo "Nenhum arquivo selecionado!";
            //exit();
        } else {
    
            //DADOS DO ARQUIVO 
            $arquivo = $_FILES['arquivo_mensagem'];
            $nome_arquivo = $arquivo['name'];
            $tamanho_arquivo = $arquivo['size'];
            $arquivo_temp = $arquivo['tmp_name'];
            $extensao_arquivo = strrchr( $nome_arquivo, '.' );
            $destino = $caminho . $nome_arquivo;
    
            //////////////
            //VALIDACOES//	
            //////////////
    
            if (!$sobrescrever && file_exists($destino) ) {
                echo "Arquivo já existe!";
                //exit();
            }
    
            if ($limitar_tamanho && $limitar_tamanho < $tamanho_arquivo) {
                    
                echo "Arquivo excede tamanho limite!";
                //exit();
            }
    
            //if (!empty( $extensoes_autorizadas ) && ! in_array($extensao_arquivo,$extensoes_autorizadas) ) {
                //echo "Tipo de arquivo não permitido!";
                //exit();
            //}
    
            //CRIANDO NOVO DIRETORIO
            //echo $diretorio_os = $caminho . $var_cd_itchamado . '/';
            
            if (@ftp_mkdir($conexao_ftp, $diretorio_os)) {

                echo 'Novo diretório criado com sucesso!';

            } else {

                //NAO FAZ NADA (OBS O @ ANTES DO NOME DA FUNCAO IGNORA OS ERROS)
                echo 'Erro ao criar diretório!';

            }

            //AJUSTE PARA ESSE PROJETO EM ESPECIFICO (PORTAL COMUNICA)
            $nome_arquivo = 'IT_' . $var_cd_itchamado . '_' . $nome_arquivo;

            //DESTINO FINAL DIRETORIO + ARQUIVO
            $diretorio_final = $caminho . $nome_arquivo;


            //ENVIA O ARQUIVO PARA O FTP
            if (@ftp_put($conexao_ftp, $diretorio_final , $arquivo_temp, FTP_BINARY)) {

                echo "Arquivo enviado com sucesso!";
                                
                //RENOMEANDO ARQUIVO	
                $renomear_diretorio_final = $caminho . $nome_arquivo;	
                ftp_rename($conexao_ftp, $diretorio_final, $renomear_diretorio_final);
            
                //ATUALIZA CHAMADO COM DADOS DO ANEXO
                $query_update_itchamado = "UPDATE portal_comunica.ITCHAMADO itch
                                        SET itch.ANEXO = '$diretorio_final',
                                            itch.EXT = '$extensao_arquivo'
                                        WHERE itch.CD_CHAMADO = '$id_chamado'";
            
                mysqli_query($conn, $query_update_itchamado); 

                echo 'CONSULTA: ' . $query_update_itchamado . ' ';
                                                        
            }  else {
                
                echo "Erro ao enviar o arquivo!";		
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


?>