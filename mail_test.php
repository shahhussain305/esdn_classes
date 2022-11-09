<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once("libs/classes/Mailer_Gmail.php");
$mail = new Communicator();
if($mail->sendEmailRnd(array('shahhussain305@gmail.com'),'ESDN','Email Test From ESDN Mailer_Gmail.php class','<b>This is testing email from esdn.ae new email for esdn.com.pk')){
    echo("Email sent");
}
else{
    echo('Failed.'. $mail->tempVar);
}
/*
echo('<hr>Another Test<hr>');
require_once("libs/classes/Mailer.php");
$mailer = new Communicator();
if($mailer->sendEmailRnd(array('shahhussain305@gmail.com'),'ESDN','Email Test From ESDN Mailer.php class','<b>This is testing email from esdn.ae new email for esdn.com.pk')){
    echo("Email sent");
}
else{
    echo('Failed.'. $mailer->tempVar);
}
*/