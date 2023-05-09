<?php

//Se o usuário não for admin
if($_SESSION['tp_usuario'] <> 'A' || $_SESSION['tp_usuario'] <> 'T'){

	unset(
		$_SESSION['nomeusuario'],
		$_SESSION['cd_usu'],		
		$_SESSION['cd_empresa_usuario_logado'],
		$_SESSION['tp_usuario'],
		$_SESSION['msgerro']
	);

	$_SESSION['msgerro'] = "Usuário sem permissão de administrador!";
	header("Location: index.php");
}

?>