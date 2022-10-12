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
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
use PHPMailer\PHPMailer\PHPMailer;
class Communicator{	
	
    private $host = "smtp.hostinger.com";
    private $userName="abc@example.com";
    private $robots = array(
				'abc1@example.com',
				'abc2@example.com',
				'abc3@example.com',
				'abc4@example.com',
				'abc5@example.com');
	private $password="EMAIL-PASSWORD-COMMON-FOR-ALL-EMAIL-ADDRESSES";
	public $replyTo="abc@example.com";
	var $tempVar;
		public $from_email='abc@example.com';
        public $from_name = 'NAME OF ORGANIZATION';
        public $charSet = "CharSet = 'UTF-8'";
        public $charSetOpt = 0;
	//function to send email simple and with attachements
	public function sendEmail($to,$from,$sender_name="",$subject,$body,$attachement_path="",$cc="",$bcc=""){ 
			require '../../../../vendor/autoload.php';		
			$mail = new PHPMailer;
			$mail->IsSMTP();            // set mailer to use SMTP i.e. smtp1.example.com;smtp2.example.com
			$mail->Host = $this->host;  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = $this->userName;  // SMTP username i.e email id of an email address
			$mail->Password = $this->password; // SMTP password for the specified email address			
			$mail->Port = 465;
			$mail->SMTPSecure = 'ssl';
                        if($this->charSetOpt != 0){
                           $mail->CharSet = $this->charSet;
                        }
			$mail->From = $from;
			$mail->FromName = $sender_name;
			$mail->addAddress($to);   //mail,name
			if(isset($cc) && !empty($cc)){
				$mail->addBCC($bcc);
				}
			if(isset($cc) && !empty($cc)){
				$mail->addCC($cc);
				}
			//$mail->AddAddress("ellen@example.com");   // name is optional
			$mail->addReplyTo($this->replyTo);//to, name			
			$mail->WordWrap = 50; 
			if(isset($attachement_path) && !empty($attachement_path)){    // set word wrap to 50 characters
					$mail->AddAttachment($attachement_path);   // add attachments
					//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
					}
			$mail->isHTML(true);   // set email format to HTML			
			$mail->Subject = $subject;
			$mail->Body = $body;
			//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";			
			if(!$mail->send()){
				$this->tempVar = $mail->ErrorInfo;
			   return false;
				}
			else{
				return true;
				}
			}
        //for multiple recipients                
        public function sendEmails($to=array(),$from,$sender_name="",$subject,$body,$attachement_path="",$cc="",$bcc=""){
			$mail = new PHPMailer();*/
			require '../../../../vendor/autoload.php';				
			$mail = new PHPMailer;
			$mail->IsSMTP();            // set mailer to use SMTP i.e. smtp1.example.com;smtp2.example.com
			$mail->Host = $this->host;  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = $this->userName;  // SMTP username i.e email id of an email address
			$mail->Password = $this->password; // SMTP password for the specified email address
			// $mail->Port = 587;
			// $mail->SMTPSecure = 'tls';
			$mail->Port = 465;
			$mail->SMTPSecure = 'ssl';
                        if($this->charSetOpt != 0){
                           $mail->CharSet = $this->charSet;
                        }
			$mail->From = $from;
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
			//$mail->AddAddress("ellen@example.com");  // name is optional
			$mail->addReplyTo($this->replyTo);//to, name			
			$mail->WordWrap = 50; 
			if(isset($attachement_path) && !empty($attachement_path)){  // set word wrap to 50 characters
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
				}
			}

           //for multiple/single recipient(s) and from random robots
           public function sendEmailRnd($to=array(),$sender_name="",$subject,$body,$attachement_path="",$cc="",$bcc=""){ 
            		$sender_robot = $this->robots[array_rand($this->robots,1)];
			require '../../../../vendor/autoload.php';				
			$mail = new PHPMailer;
			$mail->IsSMTP();            // set mailer to use SMTP i.e. smtp1.example.com;smtp2.example.com
			$mail->Host = $this->host;  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = $sender_robot;  // SMTP username i.e email id of an email address
			$mail->Password = $this->password; // SMTP password for the specified email address
			// $mail->Port = 587;
			// $mail->SMTPSecure = 'tls';
			$mail->Port = 465;
			$mail->SMTPSecure = 'ssl';
                        if($this->charSetOpt != 0){
                           $mail->CharSet = $this->charSet;
                        }
			$mail->From = $sender_robot;
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
			//$mail->AddAddress("ellen@example.com");   // name is optional
			$mail->addReplyTo($this->replyTo);//to, name			
			$mail->WordWrap = 50; 
			if(isset($attachement_path) && !empty($attachement_path)){    // set word wrap to 50 characters
					$mail->AddAttachment($attachement_path);      // add attachments
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
			}                       
	
	 
	}
