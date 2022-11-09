<?php 
//-------Display page errors------------------------------------------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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


