<?php

	// Se o usuário não está logado, manda para página de login.
	if (!isset($_SESSION['cd_usu'])){
		
		unset(
			$_SESSION['nomeusuario'],
			$_SESSION['cd_usu'],		
			$_SESSION['cd_empresa_usuario_logado'],
			$_SESSION['tp_usuario'],
			$_SESSION['msgerro']
		);
		
		$_SESSION['msgerro'] = "Sessão expirada!";
		header("Location: index.php");
		
	};

?>