<?php
// check if fields passed are empty
if(empty($_POST['name'])  		||
   empty($_POST['phone']) 		||
   empty($_POST['assunto']) 		||
   empty($_POST['email'])     ||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }
	
$name = $_POST['name'];
$phone = $_POST['phone'];
$assunto = $_POST['assunto'];
$email_address = $_POST['email'];
$message = $_POST['message'];
	/*
// create email body and send it	
$to = 'adriana@locutora.com'; // PUT YOUR EMAIL ADDRESS HERE
$email_subject = "Novo email de:  $name"; // EDIT THE EMAIL SUBJECT LINE HERE
$email_body = "Segue dados do contato.\n\n"."Detalhes:\n\nNome: $name\n\nFone: $phone\n\n Assunto: $assunto\n\nE-mail: $email_address\n\nMensagem:\n$message";
$headers = "From: site@locutora.com\n";
$headers .= "Reply-To: $email_address";	
//endereços que receberão uma copia 
//$headers .= "Cc: manel@desarrolloweb.com";
//endereços que receberão uma copia oculta
$headers .= "Bcc: elvio@elvio.com.br";
mail($to,$email_subject,$email_body,$headers);
return true;			*/

// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
// O return-path deve ser ser o mesmo e-mail do remetente.
$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$to = 'drix.rox@gmail.com'; // PUT YOUR EMAIL ADDRESS HERE
$email_subject = "Novo email de:  $name"; // EDIT THE EMAIL SUBJECT LINE HERE
$email_body = "Segue dados do contato.\n\n"."Detalhes:\n\nNome: $name\n\nFone: $phone\n\n Assunto: $assunto\n\nE-mail: $email_address\n\nMensagem:\n$message";
$headers .= "From: adrianarosa@locutora.com\r\n"; // remetente
$headers .= "Return-Path: $email_address\r\n"; // return-path
$headers .= "Bcc: drix.rox@gmail.com, elvio@elvio.com.br";
$envio = mail($to, $email_subject, $email_body, $headers);
if($envio)
return true;
/*
if($envio)
 echo "Mensagem enviada com sucesso";
else
 echo "A mensagem não pode ser enviada";
 */
?>