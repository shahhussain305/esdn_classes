<?php 
//-------Display page errors------------------------------------------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("libs/classes/SecurityPolicy.php");
$sp = new SecurityPolicy();
// Allow scripts from your domain and the Bootstrap CDN
$sp->addDirective('script-src', "'self'");
$sp->addDirective('script-src', "https://cdn.jsdelivr.net");
// Allow styles from your domain, inline styles, and the Bootstrap CDN
$sp->addDirective('style-src', "'self' 'unsafe-inline' https://cdn.jsdelivr.net");
// Allow images from your domain and another external domain
$sp->addDirective('img-src', "'self' http://esdn.com");
// Apply the CSP
$sp->apply();
//-----------------Importing Required Libraries-----------------------------
require_once("libs/classes/App_DB.php");
require_once("libs/classes/DbPathsArray.php");
//-Creating Object and passing user info to the constructor of App_DB class-
$db = new App_DB(DBU::$dba_user);//passing database login details from DbPathArray.php file
//--------------Calling of Methods from each class--------------------------
echo($db->getUserName(4));//calling of method from App_DB.php class
echo("<hr>");
//--------------------------------------------------------------------------
$db->getEmps();//calling of method directly from DB.php class
echo("<hr>");//calling of method directly from CRUD.php class
//--------------------------------------------------------------------------
$user_name = isset($_GET["user_name"]) && !empty($_GET["user_name"]) ? trim($_GET["user_name"]) : 'Shah Hussain';
$list = $db->getRecordSetFilled("SELECT emp_name FROM employees WHERE emp_name LIKE :emp_name ORDER BY sno DESC",array(":emp_name"=>'%'.$user_name.'%'));
echo("<b>Found total: ".count($list)."</b><br>");
if(count($list) > 0){
    foreach($list as $v){
        echo($v["emp_name"]."<br>");
    }
}
?>
<form method="get" action="index.php">
    Your Name = <input type="text" name="user_name" value="" placeholder="Your Name here">
    <input type="submit" name="btn" value="Submit">
</form>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


