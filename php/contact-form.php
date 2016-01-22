<?php
/*
* Contact Form Class
*/

require("phpMailer/PHPMailerAutoload.php");
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
/* Account to be used to send mail - credentials*/
define('GUSER', 'omairr.azam@gmail.com');
define('GPWD', 'HazratMuhammad1!');
/* Reciever of this mail*/
define('GRECIEVER', 'omairr.azam@gmail.com');
/* form field names */
define('F_NAME', 'inputName');
define('F_EMAIL', 'inputEmail');
define('F_MSG', 'inputMsg');





class Contact_Form{
	function __construct($details,  $message_min_length){
		
		$this->name = stripslashes($details[F_NAME]);
		$this->email = trim($details[F_EMAIL]);
		$this->subject = 'Email from Visitor  On my site'; // Subject 
		$this->message = 'Visitor Email : '.$this->email."<br>Name : ".$this->name."<br>Message : ".stripslashes($details[F_MSG]);
		$this->message_min_length = $message_min_length;
		$this->response_status = true;
		//$this->response_msg = $details['inputName'];
		
	}


	

	private function smtpmailer($to, $from, $from_name, $subject, $body) { 
		
		$mail->SMTPDebug = 2;
		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		
		//this is must to activate mail on server
		//$mail->isSendmail();
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = GUSER;                 // SMTP username
		$mail->Password = GPWD;                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->From = $from;
		$mail->FromName = $from_name;
		$mail->addAddress($to, '');     // Add a recipient
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $body;
		

		if(!$mail->send()) {
			$this->error = $mail->ErrorInfo;
		    return false;
		} else {
		    return true;
		}
	   
	}

	

	private function sendEmail(){	

		if(!$this->smtpmailer(GRECIEVER, $this->email, "Admin", $this->subject, $this->message))
		{
			$this->response_status = false;	
		}
		else 
		{
			$this->response_status = true;		
		}	
		
	}


	function sendRequest(){
		
		if($this->response_status)
		{
			$this->sendEmail();
		}

		$response = array();
		$response['status'] = $this->response_status;	
		$response['error'] = $this->error;
		
		echo json_encode($response);
	}
}


$contact_form = new Contact_Form($_POST, $message_min_length);
$contact_form->sendRequest();

?>