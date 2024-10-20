<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//ambient variables
require_once('helpers/Environment.php');

//email html template
include_once ("helpers/mail_Template.php");

use helpers\Environment;

Environment::load();

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                           //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV['SERVER'];                     //SMTP username
    $mail->Password   = $_ENV['PASSWORD'];                              //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->client_email = $_ENV['SERVER'];
    $mail->setFrom($_ENV['EMAIL'], ('Lumar Cleaning Solutions'));
    $mail->addAddress($_ENV['EMAIL'], 'Lumar Cleaning Solutions');     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo($_ENV['EMAIL'], 'Information');
   // $mail->addCC('cc@example.com');
   // $mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = ($_POST['project']);

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $street_Address = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipCode = $_POST['zipCode'];
    $service = $_POST['service'];
    $frequency = $_POST['frequency'];

    $text = $_POST['message'];

    
    $search = ['{{firstName}}', '{{lastName}}', '{{email}}', '{{phone}}'];
    $replace = [$firstName, $lastName, $email, $phone];

    $emailTemplate = $emailContent;
    $emailTemplate = str_replace($search, $replace,  $emailTemplate);
   
    $mail->Body = $emailTemplate;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
 
    // clear addresses of all types
    $mail->ClearAllRecipients(); //Limpar todos os que destinatiarios: TO, CC, BCC

    //Titulo do e-mail que será enviado
    $mail->Subject = "Possivel cliente";

    //E-mail para a qual o e-mail será enviado
    $mail->AddAddress("nerovigiann@hotmail.com");

    //Conteúdo do e-mail
    $mail->Body = "<h2>Possivel cliente:</h2>
    <br/>
    <p>nome: $firstName $lastName</p>
    <p>email:$email</P>
    <p>telefone:$phone</p>
    <p>Endereco: rua: $street_Address</p>
    <p>Cidade: $city</p> 
    <p>Estado: $state</p>
    <p>Zipcode: $zipCode.</p>
    <p>O servico vai ser: $service</P>
    <p>com frequencia de: $frequency.</p>
    <p>Descircao do servico: $text</p>";
    
    $mail->AltBody = $mail->Body;

    $enviadoCliente = $mail->Send();

    //
     echo 
        "<script>alert('Thank you for the message. We will contact you shortly.');</script>
        <script type='text/javascript'>window.location.href='https://porfolio-khaki.vercel.app/'</script>";
    } catch (Exception $e) {
        echo "<script>alert('Sorry! Please try again.');</script>
        <script type='text/javascript'>window.location.href='https://porfolio-khaki.vercel.app/'</script>"; 
    }

