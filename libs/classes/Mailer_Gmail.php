<?php 
/*
To use this new method of phpmailer follow the following steps on ubuntu:
Step 1: Install Composer
	$	sudo apt update
		sudo apt install php-cli unzip

	$	cd ~
	$	curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php

	$	HASH=`curl -sS https://composer.github.io/installer.sig`

	$	php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
			Output: Installer verified
		Note: If the output says Installer corrupt, you’ll need to repeat the download and verification process until you have a verified installer.

	*   The following command will download and install Composer as a system-wide command named composer, under /usr/local/bin:
	$	sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

	Output
	All settings correct for using Composer
	Downloading...

	Composer (version 2.3.5) successfully installed to: /usr/local/bin/composer
	Use it: php /usr/local/bin/composer

	To test your installation, run:

	$	composer

Step 2: Go to your website root directory and Run the following command
	
	$ 	composer require phpmailer/phpmailer
*/ 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
class Communicator{	
	/* to send emails from your registered domain / hosting email server
	private $host = "smtp.hostinger.com";
	private $userName="no-reply@example.com";
    	private $robots = array(
							'no-reply@example.com',
							'no-reply1@example.com',
							'no-reply2@example.com',
							'no-reply3@example.com',
							'no-reply4@example.com');
	private $password="jashdf &_isdf807%^$^sdf;_sdf*)465";

	public $from_email='no-reply@example.com';
	*/
	//-------------------------------Send Email From GMAIL SMTP Server -------------------------------//
  /*
  To activate sending emails from gmail, please do the following:
  1- login to your gmail account and go to the manage accounts (Top right under the user name logo)
  2- click on the security (left side menus)
  3- Activate the two step varification
  4- under the two step varification, click on the app password, click on the first dropdwon and select Custom name and Type any name like PHPMailer etc
  */
  private $host = "smtp.gmail.com";
  private $userName="esdn.test@gmail.com";
  private $password="qdtagtpfjynbmzkj";
	  private $robots = array(
			  array('esdn.test@gmail.com','qdtagtpfjynbmzkj')
			  );

  public $from_email='esdn.test@gmail.com';
  //--------------------------------------------------------------//
  public $replyTo="esdn.test@gmail.com";
  var $tempVar;
	  public $from_name = 'esdn.com.pk';
	  public $charSet = "CharSet = 'UTF-8'";
	  public $charSetOpt = 0;
	
      //for multiple/single recipient(s) and from random robots
      public function sendEmailRnd($to=array(),$sender_name="",$subject,$body,$attachement_path="",$cc="",$bcc=""){ 
			$this->get_email_user($this->robots);
			require 'vendor/autoload.php';				
			$mail = new PHPMailer;
			$mail->IsSMTP();            // set mailer to use SMTP i.e. smtp1.example.com;smtp2.example.com
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
			$mail->Host = $this->host;  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = $this->userName;  // SMTP username i.e email id of an email address
			$mail->Password = $this->password; // SMTP password for the specified email address
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
                        if($this->charSetOpt != 0){
                           $mail->CharSet = $this->charSet;
                        }
			$mail->From = $this->userName;
			$mail->FromName = $sender_name;
			//$mail->addAddress($to[0]);   //mail,name
			foreach($to as $value){
				$mail->addAddress($value); 
				}
			if(isset($bcc) && !empty($bcc)){
				$mail->addBCC($bcc);
				}
			if(isset($cc) && !empty($cc)){
					$mail->addCC($cc);
				}
			//$mail->AddAddress("ellen@example.com");                  // name is optional
			$mail->addReplyTo($this->replyTo);//to, name			
			$mail->WordWrap = 50; 
			if(isset($attachement_path) && !empty($attachement_path)){                                // set word wrap to 50 characters
					$mail->AddAttachment($attachement_path);         // add attachments
					//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
					}
			$mail->isHTML(true);                                  // set email format to HTML			
			$mail->Subject = $subject;
			$mail->Body = $body;
			//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";			
			if(!$mail->send()){
				$this->tempVar = $mail->ErrorInfo;
                return false;
				}
			else{
				return true;
                $this->tempVar = $from;
				}
				$mail->smtpClose();
			}                       
		private function get_email_user($robots_array=array()){
			try{
				if(is_array($robots_array) && count($robots_array) > 0){
					//get random user id with password from the $robots array
					$sender_robot_ary = $this->robots[array_rand($this->robots,1)];
					$this->userName = $sender_robot_ary[0];
					$this->password = $sender_robot_ary[1];
				}
			}catch(Exception $exc){
				$this->tempVar = $exc;
				}
			}
	 
	}
