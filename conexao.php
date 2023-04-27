<?php

	$servidor = '10.112.0.5';
	$usuario = 'root';
	$senha = '';
	$dbname = 'portal_comunica';

	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

	//APENAS PARA FACILITAR DIREITORIO FTP
	$diretorio_arquivos_ftp = "http://kpi.santacasasjc.com.br/";
	
?>
