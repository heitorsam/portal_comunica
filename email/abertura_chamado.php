<?php

    session_start();
    include_once('../conexao.php');

    //COLETANDO INFORMACOES ATRAVES DO GET
    $var_cd_chamado = $_GET['cd_chamado'];
    $var_msg_email = $_GET['msg_email'];


?>


<?php

//EMAIL 

$nome = 'Suporte';
$email = 'projetos@santacasasjc.com.br';
$assunto = "Abertura do chamado " . $var_cd_chamado;
$msg = "Olá! <br><br>";

$msg .= $var_msg_email;

$msg .=" 

<br><br> --- <br><br>

Projeto desenvolvido pela equipe de Projetos da Santa Casa de São José dos Campos

<br><br>Conheça nosso portfólio: <a href='http://10.200.0.50:8080/portal_projetos/portfolio_att.php'>Clique Aqui</a>

<br><br> --- 

<br><br> Atenciosamente,

<br><br><br>
	
<img src='https://kpi.santacasasjc.com.br/img/santa_casa_sjc.gif' style='width: 20%; height: 16%;'>

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
	
// InstÃ¢ncia a classe PHPMailer
$mail = new PHPMailer();
	
// ConfiguraÃ§Ã£o dos dados do servidor e tipo de conexÃ£o (Estes dados vocÃª obtem com seu host)
$mail->IsSMTP(); // Define que a mensagem serÃ¡ SMTP
$mail->Host = "smtp.santacasasaudesjc.com.br"; // EndereÃ§o do servidor SMTP
$mail->Port = 587;
$mail->CharSet = 'UTF-8';
$mail->SMTPAuth = true; // AutenticaÃ§Ã£o (True: Se o email serÃ¡ autenticado | False: se o Email nÃ£o serÃ¡ autenticado)
$mail->Username = 'webmaster@santacasasjc.com.br'; // UsuÃ¡rio do servidor SMTP
$mail->Password = '@Tecnologia#2018'; // A Senha do email indicado acima
// Remetente (IdentificaÃ§Ã£o que serÃ¡ mostrada para quem receber o email)
$mail->From = "webmaster@santacasasjc.com.br";
$mail->FromName = "Portal Comunica";
	
// DestinatÃ¡rio
$mail->AddAddress($email, $nome);

// Opcional (Se quiser enviar cÃ³pia do email)
//$mail->AddCC('copia@dominio.com.br', 'Copia'); 

$mail->AddBCC('suporte2_sistemas@santacasasjc.com.br', 'Copia Oculta');
$mail->AddBCC('projetos4@santacasasjc.com.br', 'Copia Oculta');
//$mail->AddBCC('servicedesk@santacasasjc.com.br', 'Copia Oculta');
//$mail->AddBCC('projetos@santacasasjc.com.br', 'Copia Oculta');
//$mail->AddBCC('central.cadastro1@santacasasjc.com.br', 'Copia Oculta');
//$mail->AddBCC('projetos4@santacasasjc.com.br', 'Copia Oculta');
//$mail->AddBCC('suporte2_sistemas@santacasasjc.com.br', 'Copia Oculta');

// Define tipo de Mensagem que vai ser enviado
$mail->IsHTML(true); // Define que o e-mail serÃ¡ enviado como HTML

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
	echo "Houve um erro ao enviar o email! " .$mail->ErrorInfo;
}


?>

