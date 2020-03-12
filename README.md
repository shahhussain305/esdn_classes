# esdn
Classes which helps to build web based application very quickly- just use if and else for transaction.
Example of how to use these libraries:

1- ----------------------Example : how to connect to database(s) ----------------------------
open libs/classes/DbPathsArray.php and add as many as databases details you need in your project

in the following class in the above file:

     class DBU {
    
       static $view_user = array(
                                'user'=>'dmlld19vbmx5', //base64_encoded string including the user name of database
                                'key'=>'VGVzdF9Vc2VyMSE=',//base64_encoded string including the password for the above db user 
                                'host'=>'bG9jYWxob3N0',//base64_encoded string of localhost
                                'db'=>'cGhjX2Nhc2VmbG93'//name of database encoded with base64_encode() method
                                );
    static $dba_user = array(
                                'user'=>'ZGJhX3VzZXI=',
                                'key'=>'RGJBX1VzRXIxIQ==',
                                'host'=>'bG9jYWxob3N0',
                                'db'=>'cGhjX2Nhc2VmbG93'
                                );
        }//end class
        
Step 2: Now you can use the libs/classes/App_DB.php class file but remember not to change the mentioned code as 
    
      -Do not edit the below---

while you can write your own methods which will work for your db transactions etc


2: --------------------Working Example--------------------
Create index.php file in your root directory and use the following testing code:

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
                $list = $db->getRecordSetFilled("SELECT CONCAT(emp_name,' S/O ',father_name) as emp_name FROM employees WHERE emp_name LIKE :emp_name ORDER BY sno DESC",array(":emp_name"=>'%'.$user_name.'%'));
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

That's all....for databases section
