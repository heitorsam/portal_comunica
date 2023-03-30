<?php 
	include 'conexao.php';

	session_start();

	$cd_usu = $_POST['login'];
	$cd_senha = $_POST['senha'];

	$consulta_login_qtd = " SELECT COUNT(*) AS QTD 
							FROM portal_comunica.USUARIO usu 
							WHERE usu.NM_USUARIO = '$cd_usu' 
							AND usu.SENHA = '$cd_senha'";
							
	$consulta_login = " SELECT * 
						FROM portal_comunica.USUARIO usu 
						WHERE usu.NM_USUARIO = '$cd_usu' 
						AND senha = '$cd_senha'";

	$result_login_qtd = mysqli_query($conn, $consulta_login_qtd);
	$result_login = mysqli_query($conn, $consulta_login);
	$row_qtd = mysqli_fetch_array($result_login_qtd);
	$row_login = mysqli_fetch_array($result_login);

	$_SESSION['nomeusuario'] = $row_login['NM_USUARIO'];

	if($row_qtd['QTD'] == '1') {

		$_SESSION['cd_usu'] = $row_login['CD_USUARIO'];

		header("Location: home.php");
		exit;

	} else {

		$_SESSION['msgerro'] = "Usuario ou senha invalido";

		header("Location: index.php");
		exit;

	}
	
?>