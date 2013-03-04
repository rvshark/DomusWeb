<?php

require("lib/class.phpmailer.php"); // Chama o arquivo da classe
define('SMTP_PORT', 587);

$email = 'lorena.b.rodrigues@gmail.com';
$nome = 'Lorena';  
$data = date('d/m/Y H:i:s');

$nome_puc='Domus';
$email_puc='no-reply_domus@pucpr.br';

$texto_puc = "O usuário $nome , com e-mail $email <br/> Enviou essa solicitação da data $data.";
$texto_usuario ="Olá seu cadastro foi enviado , em breve entraremos em contato <br/> Resposta automática , por favor não responda esse e-mail<br/>Obrigado.";

$para_puc = enviar_email($nome,$email,$nome_puc,$email_puc,$texto_puc);
$para_usuario = enviar_email($nome,$email,$nome,$email,$texto_usuario);
 
echo $para_puc;


function enviar_email($nome,$email,$nome_to,$email_to,$texto){
$mail = new PHPMailer();
$mail->SetLanguage("br"); 
$mail->CharSet = "iso-8859-1"; 
$mail->IsSMTP(); 
$mail->Host="pod51004.outlook.com"; 
$mail->SMTPAuth = true; 
$mail->SMTPSecure = 'tls';

$mail->Username = "no-reply_domus@pucpr.br";
$mail->Password = "1234@puc"; 
$mail->IsHTML(true); 
$mail->From = "no-reply_domus@pucpr.br"; 
$mail->FromName = "Domus"; 
$mail->AddAddress("$email_to","$nome_to"); 
$mail->AddReplyTo("$email","$nome"); 


$mail->Subject = "Acesso ao site Domus [$nome]";
$mail->Body = "$texto";
//$mail->AltBody = "Corpo da Mensagem somente Texto, sem formatações"; 

if(!$mail->Send()){
   return 0;
}else{
   return 1;
}

}

?>
