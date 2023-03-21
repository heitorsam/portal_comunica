<?php
	session_start();	
		
	//Incluindo a conexão com banco de dados
	include 'conexao.php';
	
	$pag_apos = 'home.php';	
	$pag_login = 'index.php';

	//O campo usuário e senha preenchido entra no if para validar
	if((isset($_POST['login'])) && (isset($_POST['senha']))){

		//Buscar na tabela usuario o usuário que corresponde com os dados digitado no formulário		
		//$result_usuario = "SELECT * FROM usuarios WHERE login = '$usuario' && senha = '$senha' LIMIT 1";
		
		$usuario = strtoupper($_POST['login']);
		$senha = $_POST['senha'];	
		
		echo $usuario;	echo '</br>'; echo $senha; echo '</br>';
		
		$result_usuario = oci_parse($conn_ora, "SELECT portal_relatorios.VALIDA_SENHA_FUNC_LOGIN(:usuario,:senha) AS RESP_LOGIN,
												(SELECT INITCAP(usu.NM_USUARIO)
													FROM dbasgu.USUARIOS usu
													WHERE usu.CD_USUARIO = :usuario) AS NM_USUARIO,													
													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 428) THEN 'S' --PAPEL GERAL
													END SN_USUARIO,

													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 429) THEN 'S' --PAPEL CUSTOS
													END SN_CUSTOS,

													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 430) THEN 'S' --PAPEL SEPSE
													END SN_SEPSE,

													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 435) THEN 'S' --PAPEL REPASSE
													END SN_REPASSE,

													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 436) THEN 'S' --PAPEL SAE
													END SN_SAE,

													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 440) THEN 'S' --EXAMES REALIZADOS
													END SN_RX,

													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 444) THEN 'S' --PROCEDIMENTO SUS
													END SN_PROC_SUS,

													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 447) THEN 'S' --ENDOSCOPIA
													END SN_ENDOSCOPIA,

													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 454) THEN 'S' --MARCADORES CIRURGICOS
													END SN_MARCADORES_CIRURGICOS


												FROM DUAL");																															
												
		oci_bind_by_name($result_usuario, ':usuario', $usuario);
		oci_bind_by_name($result_usuario, ':senha', $senha);

		echo '</br> RESULT USUARIO:' . $result_usuario . '</br>';
		
		oci_execute($result_usuario);
        $resultado = oci_fetch_row($result_usuario);

		echo '</br> COLUNA 0:' . $resultado['0']  . ' - ' . $resultado['1'] . '</br>';
		
		//Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		if(isset($resultado)){
			
			if($resultado[0] == 'Login efetuado com sucesso') {

				$cons_acesso_login="INSERT INTO portal_projetos.ACESSO
				SELECT portal_projetos.SEQ_CD_ACESSO.NEXTVAL AS CD_ACESSO,
				24 AS CD_PORTFOLIO,
				'PORTAL RELATORIOS' AS DS_PROJETO,
				'$usuario' AS CD_USUARIO_ACESSO,
				SYSDATE AS HR_ACESSO
				FROM DUAL";

				$result_acesso = oci_parse($conn_ora,$cons_acesso_login);

				$valida_acesso = oci_execute($result_acesso);

				if($valida_acesso){

					$_SESSION['usuarioLogin'] = $usuario;
					$_SESSION['usuarioNome'] = $resultado[1];
					$_SESSION['SN_USUARIO'] = $resultado[2];
					$_SESSION['SN_CUSTOS'] = $resultado[3];
					$_SESSION['SN_SEPSE'] = $resultado[4];
					$_SESSION['SN_REPASSE'] = $resultado[5];
					$_SESSION['SN_SAE'] = $resultado[6];
					$_SESSION['SN_RX'] = $resultado[7];
					$_SESSION['SN_PROC_SUS'] = $resultado[8];
					$_SESSION['SN_ENDOSCOPIA'] = $resultado[9];
					$_SESSION['SN_MARCADORES_CIRURGICOS'] = $resultado[10];
					header("Location: $pag_apos");

				}

			} else { 
				$_SESSION['msgerro'] = $resultado[0] . '!';
				header("Location: $pag_login");		
			}
		//Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		//redireciona o usuario para a página de login
		}else{	
			//Váriavel global recebendo a mensagem de erro
			$_SESSION['msgerro'] = "Ocorreu um erro!";
			header("Location: $pag_login");
		}
		
	}
?>

<!--LISTA DE PAPEIS -->

<!--PAPEL PORTAL CUSTOS : 429-->