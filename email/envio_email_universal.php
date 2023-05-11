<?php

    session_start();
    include_once('../conexao.php');

    //COLETANDO INFORMACOES ATRAVES DO GET
    $var_cd_chamado = $_GET['cd_chamado'];
    $var_msg = $_GET['msg'];
    $var_titulo = $_GET['titulo'];
    $var_grupo_dest = $_GET['grupo_dest'];

?>

<?php

//EMAIL 

$nome = 'Projetos';
$email = 'projetos4@santacasasjc.com.br';
$assunto = "(OS: " . $var_cd_chamado . ") " . $var_titulo;
$msg = "Olá! <br><br>";

$msg .= $var_msg;

$msg .=" 

<br><br>

<a href='http://10.200.0.50:8080/portal_comunica/'>Portal Comunica</a>

<br><br> --- <br><br>

Projeto desenvolvido pela equipe de Projetos da Santa Casa de São José dos Campos

<br><br>Conheça nosso portfólio: <a href='http://10.200.0.50:8080/portal_projetos/portfolio_att.php'>Clique Aqui</a>

<br><br> --- 

<br><br> Atenciosamente,

<br><br><br>
	
<img src='https://kpi.santacasasjc.com.br/img/santa_casa_sjc.gif' style='width: 20%; height: 12%;'>

</br></br>";

//VERIFICANDO MENSAGEM:
ECHO $msg;

if (PATH_SEPARATOR ==":") { $quebra = "\r\n"; } 
else { $quebra = "\n"; }	
$headers = "MIME-Version: 1.1".$quebra;	
$headers .= "Content-type: text/plain; charset=iso-8859-1".$quebra;	
$headers .= "From: webmaster@santacasasjc.com.br".$quebra; 
//E-mail do remetente	
$headers .= "Return-Path: webmaster@santacasasjc.com.br".$quebra; 
				   
// Chame o arquivo com as Classes do PHPMailer
require_once('../phpmailer/class.phpmailer.php');
	
// Instancia a classe PHPMailer
$mail = new PHPMailer();
	
// ConfiguraÃ§Ã£o dos dados do servidor e tipo de conexao (Estes dados voce obtem com seu host)
$mail->IsSMTP(); // Define que a mensagem sera SMTP
$mail->Host = "smtp.santacasasaudesjc.com.br"; // Endereco do servidor SMTP
$mail->Port = 587;
$mail->CharSet = 'UTF-8';
$mail->SMTPAuth = true; // Autenticacao (True: Se o email sera autenticado | False: se o Email nao sera autenticado)
$mail->Username = 'webmaster@santacasasjc.com.br'; // Usuario do servidor SMTP
$mail->Password = '@Tecnologia#2018'; // A Senha do email indicado acima
// Remetente (Identificao que sera¡ mostrada para quem receber o email)
$mail->From = "webmaster@santacasasjc.com.br";
$mail->FromName = "Portal Comunica";
	
// Destinatario
$mail->AddAddress($email, $nome);

// Opcional (Se quiser enviar copia do email)
//$mail->AddCC('copia@dominio.com.br', 'Copia'); 
//$mail->AddBCC('projetos4@santacasasjc.com.br', 'Copia Oculta');

if($var_grupo_dest == 'a'){

    echo "</br>Regra quem abriu</br>";

    $consulta_emails = "SELECT usu.CD_USUARIO, usu.NM_USUARIO, usu.EMAIL
                        FROM bd_comunic.USUARIO usu
                        WHERE usu.CD_USUARIO IN (SELECT ch.CD_USUARIO_CADASTRO
                                                FROM bd_comunic.CHAMADO ch 
                                                WHERE ch.CD_CHAMADO = $var_cd_chamado)";
    

    $res_emails = mysqli_query($conn, $consulta_emails);

    while ($row_email = mysqli_fetch_array($res_emails)) {

        $mail->AddBCC($row_email['EMAIL'], 'Copia Oculta');

    }
}

if($var_grupo_dest == 'r'){

    echo "</br>Regra quem recebeu</br>";

    $consulta_emails = "SELECT usu.CD_USUARIO, usu.NM_USUARIO, usu.EMAIL
                        FROM bd_comunic.USUARIO usu
                        WHERE usu.CD_USUARIO IN (SELECT ch.CD_USUARIO_RESPONSAVEL
                                                FROM bd_comunic.CHAMADO ch 
                                                WHERE ch.CD_CHAMADO = $var_cd_chamado)";
    

    $res_emails = mysqli_query($conn, $consulta_emails);

    while ($row_email = mysqli_fetch_array($res_emails)) {

        $mail->AddBCC($row_email['EMAIL'], 'Copia Oculta');

    }

}

if($var_grupo_dest == 'g'){

    echo "</br>Regra grupo</br>";

    $consulta_emails = "SELECT usu.CD_USUARIO, usu.NM_USUARIO, usu.EMAIL
                              FROM bd_comunic.USUARIO usu
                              WHERE usu.CD_USUARIO IN(SELECT gp.CD_USUARIO
                                                      FROM bd_comunic.GRUPO_USUARIO gp
                                                      WHERE gp.CD_GRUPO IN (SELECT ch.CD_GRUPO
                                                                          FROM bd_comunic.CHAMADO ch 
                                                                          WHERE ch.CD_CHAMADO = $var_cd_chamado))";
    

    $res_emails = mysqli_query($conn, $consulta_emails);

    while ($row_email = mysqli_fetch_array($res_emails)) {

        $mail->AddBCC($row_email['EMAIL'], 'Copia Oculta');

    }
}

// Define tipo de Mensagem que vai ser enviado
$mail->IsHTML(true); // Define que o e-mail sera enviado como HTML

// Assunto e Mensagem do email
$mail->Subject  = $assunto; // Assunto da mensagem
$mail->Body = $msg;	
//$mail->AddAttachment($_SERVER['DOCUMENT_ROOT']. '/upload/123.pdf');
	
	
// Envia a Mensagem
$enviado = $mail->Send();

// Verifica se o email foi enviado
if($enviado)
{
	echo "E-mail enviado com sucesso!";

}
else
{
	echo "Houve um erro ao enviar o email! " . $mail->ErrorInfo;
}


?>

