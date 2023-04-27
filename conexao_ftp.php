<?php

    //////////////
	//DADPOS FTP//	
	//////////////

    //IP FTP
    $servidor_ftp = '187.45.195.235';

    //USUARIO E SENHA
    $usuario_ftp = 'portal_kpi@santacasasjc1';
    $senha_ftp   = 'SJCSantaCasa@789';

    ///////////////
	//CONEXAO FTP//	
	///////////////

	$conexao_ftp = ftp_connect( $servidor_ftp );
	$login_ftp = @ftp_login( $conexao_ftp, $usuario_ftp, $senha_ftp);

	//NECESSARIO SENAO O ARQUIVO SOBE NO SERVIDOR COM 0 BITES
	ftp_pasv($conexao_ftp, true) or die("Unable switch to passive mode");

	if (!$login_ftp) {	
		echo "Login ou senha do FTP incorreto!";
		//exit();	
	}else{

        echo 'Login efetuado com sucesso!';
    }

?>