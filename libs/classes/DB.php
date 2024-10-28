<?php
//-------------------------------Do not edit the below ----------------------------//
 require_once('CRUD.php');
 class DB extends CRUD{   
    protected function __construct($db_details_ary = array()) {
        try{
            if(isset($db_details_ary) && !empty($db_details_ary)){
                parent::__construct(base64_decode($db_details_ary["user"]), base64_decode($db_details_ary["key"]), base64_decode($db_details_ary["host"]), base64_decode($db_details_ary["db"]));                
            }else{
                echo("Invalid User Attempt To Database! ::Parent::");
                //print_r($db_details_ary);
                exit();
            }
        }catch(Exception $exc){
            $this->tempVar = $exc->getTraceAsString();
        }
    }
    
    //---------------------------------- Do not edit the above ------------------------//
    public function getEmps(){
	try{
    		$employees = $this->getRecordSetFilled("SELECT emp_name FROM employees ORDER BY sno DESC limit 10");
       			 if(count($employees) > 0){
            			foreach($employees as $emp){
               				 echo("Emp Name = ".$emp["emp_name"]."<br>");
                			}
        		}else{
            			echo("No employee was found");
        			}
			}catch(Exception $ex){
    				echo($ex->getTraceAsString());
			}
		}



    
}//DB()
