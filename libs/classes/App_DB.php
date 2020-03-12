<?php
//-----------------------Do not edit the below ----------------------//
require_once('DB.php');
class App_DB extends DB{   
    public function __construct($db_details_ary = array()) {
        try{
            if(isset($db_details_ary) && !empty($db_details_ary)){
                parent::__construct($db_details_ary);                
            }else{
                echo("Invalid User Attempt To Database!");
                exit();
            }
        }catch(Exception $exc){
            $this->tempVar = $exc->getTraceAsString();
        }
    }
    //---------------------Do not edit the above --------------------//

    public function getUserName($sno){
	try{
		return $this->getValue("SELECT emp_name FROM employees WHERE sno = :sno ORDER BY sno DESC",array(":sno"=>$sno));
		}catch(Exception $exc){
			$this->tempVar = $exc->getMessage();
		}
	}
    
    
}//DB()
