<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\POP3;
use PHPMailer\PHPMailer\SMTP;

if(!isset($_REQUEST['subject']) || !isset($_REQUEST['email']) || !isset($_REQUEST['fname']) || !isset($_REQUEST['lname']) || !isset($_REQUEST['subject'])) {
	echo 'failed';
	exit;
}

include('./phpmailer/src/Exception.php');
include('./phpmailer/src/OAuth.php');
include('./phpmailer/src/PHPMailer.php');
include('./phpmailer/src/POP3.php');
include('./phpmailer/src/SMTP.php');

$pass = base64_decode('PASS HERE');

$mail = new PHPMailer();
//Server settings
$mail->SMTPDebug = 2;                                 // 0 = disabled, 2 = Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'it@corporate-happiness.de';                 // SMTP username

$mail->Password = $pass;                           // SMTP password

//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//$mail->Port = 587;                                    // TCP port to connect to#

$mail->SMTPSecure = false;
$mail->SMTPAutoTLS = false;

//Sender Information
$mail->setFrom($_REQUEST['email']);
$mail->addReplyTo($_REQUEST['email']);

$subject = 'Kontaktformular Online-Kurs '.$_REQUEST['subject']; // Subject of your email
$to = 'it@corporate-happiness.de';  //Recipient's or Your E-mail

$message = '';
$message .= 'First Name: ' . $_REQUEST['fname'] . "<br>";
$message .= 'Last Name: ' . $_REQUEST['lname'] . "<br>";
$message .= 'Kontaktformular Online-Kurs: ' . $_REQUEST['subject'] . "<br><br><br>";
$message .= $_REQUEST['message'];

//Recipient
$mail->addAddress($to);     // Add a recipient


//Content
$mail->CharSet = "UTF-8"; 
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = $subject;
$mail->Body    = $message;
$mail->AltBody = $message;

try {
	if($mail->send()) {
		echo 'sent';
	} else {
		echo $mail->ErrorInfo;	
	}
} catch(\Exception $e) {
	echo $mail->ErrorInfo;
}