<?php
/** written and edited by Brian Martey 
*/
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
require_once("PHPMailer-master/class.phpmailer.php");
require 'PHPMailer-master/PHPMailerAutoload.php';
	
class emailclass{
	function emailclass(){
	}

	function sendinfo($booker, $email){
		//Email portion of the code
		$account="niimmartei@gmail.com";
		$password="Flipper1mum&dad";
		$from="eduapp@ashesi.edu.gh";
		$from_name="EduApp Platform";
		$subject="Assignment Notification";
		$message="Assignment Recieved from ".$booker.".<br> Please check it in the Application</a>.<br> Thank you. ";

		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
	    $mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth= true;
		$mail->Port = 465; //587;
		$mail->Username= $account;
		$mail->Password= $password;
		$mail->SMTPSecure = 'ssl';// 'tls';
		$mail->From = $from;
	    $mail->FromName= $from_name;
		$mail->addAddress($email);	  
		$mail->isHTML(true);                                 
		$mail->Subject = $subject;
		$mail->Body    = $message;

		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent. ';
		}
	}

	function resendinfo($booker, $email){
		//Email portion of the code
		$account="niimmartei@gmail.com";
		$password="Flipper1mum&dad";
		$from="eduapp@ashesi.edu.gh";
		$from_name="EduApp Platform";
		$subject="Assignment Notification";
		$message="Assignment Submitted by ".$booker.".<br> Please review it in the Application</a>.<br> Thank you. ";

		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
	    $mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth= true;
		$mail->Port = 465; //587;
		$mail->Username= $account;
		$mail->Password= $password;
		$mail->SMTPSecure = 'ssl';// 'tls';
		$mail->From = $from;
	    $mail->FromName= $from_name;
		$mail->addAddress($email);	  
		$mail->isHTML(true);                                 
		$mail->Subject = $subject;
		$mail->Body    = $message;

		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent. ';
		}
	}

	function updateinfo($booker,$title,$date,$email){
		//Email portion of the code
		$account="niimmartei@gmail.com";
		$password="Flipper1mum&dad";
		$from="eduapp@ashesi.edu.gh";
		$from_name="EduApp Platform";
		$subject="Assignment Notification";
		$message="Assignment Resubmitted by ".$booker.".<br> Please review it in the Application</a>. <br>Assignment Information:<br> Title: ".$title."<br> Date: ".$date."<br> Thank you. ";

		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
	    $mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth= true;
		$mail->Port = 465; //587;
		$mail->Username= $account;
		$mail->Password= $password;
		$mail->SMTPSecure = 'ssl';// 'tls';
		$mail->From = $from;
	    $mail->FromName= $from_name;
		$mail->addAddress($email);	  
		$mail->isHTML(true);                                 
		$mail->Subject = $subject;
		$mail->Body    = $message;

		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent. ';
		}
	}


	function recieveinfo($request,$title,$date,$email){
		$account="niimmartei@gmail.com";
		$password="Flipper1mum&dad";
		$from="eduapp@ashesi.edu.gh";
		$from_name="EduApp Platform";
		$subject="Assignment Status";
		$message="Your Assignment was <b>".$request."</b>.<br> Assignment Information:<br> Title: ".$title."<br> Date: ".$date."<br>Thank you. ";

		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
	    $mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth= true;
		$mail->Port = 465; //587;
		$mail->Username= $account;
		$mail->Password= $password;
		$mail->SMTPSecure = 'ssl';// 'tls';
		$mail->From = $from;
	    $mail->FromName= $from_name;
		$mail->addAddress($email);	  
		$mail->isHTML(true);                                 

		$mail->Subject = $subject;
		$mail->Body    = $message;

		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent. ';
		}
	}
}
?>