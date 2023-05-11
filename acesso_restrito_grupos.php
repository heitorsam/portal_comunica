<?php

	$consulta_grupos_permissoes="SELECT 
	CASE
	  WHEN COUNT(tot.SN_ACESSA_PAGINA_GRUPO) > 0 THEN 'S'
	  ELSE 'N'
	END AS SN_LIBERA_PAGINA
	FROM(
	SELECT 
	CASE
	  WHEN gp.CD_GRUPO IN (SELECT res.CD_GRUPO
							FROM (
							SELECT ch.CD_GRUPO
							FROM bd_comunic.CHAMADO ch
							WHERE ch.CD_CHAMADO = $id_chamado
	
							UNION ALL
	
							SELECT gu.CD_GRUPO
							FROM bd_comunic.GRUPO_USUARIO gu
							WHERE gu.CD_USUARIO IN (SELECT ch.CD_USUARIO_CADASTRO
													FROM bd_comunic.CHAMADO ch
													WHERE ch.CD_CHAMADO = $id_chamado)) res) THEN 'S'
	ELSE 'N'
	END AS SN_ACESSA_PAGINA_GRUPO
	FROM bd_comunic.GRUPO_USUARIO gp
	WHERE gp.CD_USUARIO = $cd_usuario_logado) tot
	WHERE tot.SN_ACESSA_PAGINA_GRUPO = 'S'";

	$res_gp_usu_perm = mysqli_query($conn, $consulta_grupos_permissoes);

	$row_gp_usu_perm = mysqli_fetch_array($res_gp_usu_perm);

	$var_sn_libera_pagina = $row_gp_usu_perm['SN_LIBERA_PAGINA'];

	if($var_sn_libera_pagina == 'N'){

		header('Location: home.php');
	}

?>