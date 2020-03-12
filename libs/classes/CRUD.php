<?php 
/*_____________________________________________________________________________________
	Author of the Script: 				Shah  Hussain 
	Email: 								shahhussain305@gmail.com
	URL: www.esdn.com.pk
	-----------------------------------------------------------------------------------
	Use of PDO (PHP Data Objects: 
	1- Open your php.ini file and search for:
	   ;extension=php_pdo_mysql.dll
	   Remove ";" from starting of the line and it will enable the PDO for MySql Database
	   Tested on IIS Version: 8.5.9600.16384 Windows 8.1 Professinal, Ubuntu 16.04, 18.04
	2- UnComment 
			//echo($ex->getMessage()); //Developer Machine: Display Exceptions in browser	
  _______________________________________________________________________________________*/

class CRUD{
	private $db_user;
	private $db_pass;
	private $db_name;
	private $host;
	protected $con;

	//To check sql query if needed
	public $sqlToReturn;
	public $tempVar;
	
	//default constructor to build the connection to db
	protected function __construct($user,$key,$host,$db){
		$this->db_user = $user;
		$this->db_pass = $key;
		$this->db_name = $db;
		$this->host = $host;
		}
			
	function __destruct(){
		try{
			$this->con = null;
		}catch(PDOException $exc){
			
			}
		}
	/**
         * connect() function to connect to database
         */
	protected function connect(){
		try{
			$this->con = new PDO("mysql:host={$this->host};dbname={$this->db_name};charset=utf8", $this->db_user, $this->db_pass); 
                        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
           	}catch(PDOException $ex){
			return $ex->getMessage();
			}
		}
    /**	___________________________________________________________________________________________
		getRecordSet() function takes simple plain sql query or parameterized quwery 
		//simple query = select * from table
		//param query = select * from table where sno = :sno and col_2 = :col_2 AND name LIKE :name
		//WHERE name LIKE :name should be $name = '%text' or '%text%'
		___________________________________________________________________________________________
		Code Snippet: 
			$sno = 1;
			$user_name = '%hussain%';
			$aray = array(':sno'=>$sno,':user_name'=>$user_name);
			foreach($crud->getRecordSet("SELECT * FROM users WHERE sno = :sno AND user_name LIKE :user_name",$aray) as $row){
				echo('<br>'.$row['user_name']);
				echo('<br>'.$row['user_password']);
				echo('<br>'.$row['date_reg']);
				}
		____________________________________________________________________________________________ */
		
			public function getRecordSet($sql,$bindVars=array()){
				try{
					$this->connect();
					$statement = $this->con->prepare($sql);
					$statement->execute($bindVars);
					return $statement->fetchAll();
					$this->con = null;
				}catch(PDOException $ex){
					return $ex->getMessage(); //Developer Machine: Display Exceptions in browser
					}				
				}//getRecordSet()
			/**
                         * function to return the filled array/ResultSet according to the provided query, otherwise returns null array
                         * length of the array will be less than 1 
                         * Usage: 
                         * $rs = $db->getRecordSetFilled($sql,$bindVars=array());
                         * if($rs > 0){
                         *      foreach($rs as $r){
                         *          .......
                         *      }
                         * }
                         * else{
                         *      echo($method->errorMsg("","Sorry there was no record found"));
                         * }
                         */
                        public function getRecordSetFilled($sql,$bindVars=array()){
				try{
					$this->connect();
					$statement = $this->con->prepare($sql);
					$statement->execute($bindVars);
                                        $is_there_any_row = $statement->rowCount();//if greater than 0, it will return result set
                                        if(isset($is_there_any_row) && $is_there_any_row > 0){
                                            return $statement->fetchAll();
                                        }
                                        else{
                                            return array();//means no record was found
                                        }
					$this->con = null;
				}catch(PDOException $ex){
					return $ex->getMessage(); //Developer Machine: Display Exceptions in browser
					}				
				}//getRecordSet()        
		/** ___________________________________________________________________________________________
		getValue() function takes two parameters 
			1- Query : proper sql query 			   
			   $sql = 'SELECT * FROM table WHERE sno = :sno';
			2- $bindVars : Array i.e. 
			   $sno = 30;
			   $arry = array(":sno"=>$sno);
		   ____________________________________________________________________________________________
		   Code Snippet:
		   		$user_name = '%sh%';
				$aray = array(':user_name'=>$user_name);
				$sql = "SELECT user_name FROM users WHERE user_name LIKE :user_name";
				echo($crud->getValue($sql,$aray));	   
		   ____________________________________________________________________________________________	*/		
		
		public function getValue($sql,$bindVars=array()){
			try{			
					$this->connect();
					$statement = $this->con->prepare($sql);
					$statement->execute($bindVars);
					return $statement->fetchColumn();
					$this->con = null;
				}catch(PDOException $ex){
					return $ex->getMessage(); //Developer Machine: Display Exceptions in browser
					}
			}	
		
		/**_____________________________________________________________________________________________
		dbQuery() function takes two parameters 
			1-	$sql : A proper Sql Query that could be perameterized or non-perameterized
			2-	$bindVars : An array() holds bindable values for where clause 
			_________________________________________________________________________________________
		Code Snippet: 
				$ary = array(':user_name'=>'shahhussain');
				$sql = "SELECT * FROM users WHERE user_name = :user_name";
				//echo($crud->search($sql,$ary));   // will show 1 or 0
				if($crud->dbQuery($sql,$ary)){
					echo('Result Found');
					}
				else{
					echo('Result was not found');
					}
			OR
			      $sql = "SELECT * FROM users";
					//echo($crud->dbQuery($sql));   // will show 1 or 0
					if($crud->search($sql)){
						echo('Result Found');
						}
					else{
						echo('Result was not found');
						}
		Note: This method will run INSERT , UPDATE , DELETE and Search Queries.
		___________________________________________________________________________________________*/	
		
		public function dbQuery($sql,$bindVars=array()){
			try{
				$this->connect();
				$statement = $this->con->prepare($sql);
				$statement->execute($bindVars);
				if($statement->rowCount() > 0){
					return true;
					}
				else{
					return false;
					}
					$this->con = null;
				}catch(PDOException $exc){
					$this->tempVar = $exc->getMessage(); //for debugging purpose only
					return false;
					}
			}		
			
			
	  		
		/** 
                 * ______________________________________________________________________________________________________
		fillCombo() function takes 4 @params 
			1- $sql : proper sql query 
			2- $valueMember : column name i.e. "sno" (<option value='$valueMember'> $valueMember </option>)
			3- $displayMember : column name i.e. "Title" (<option value='$valueMember'> $displayMember </option>)
			4- $bindVars : array() with filled values if WHERE clause has used in query [Optional]
		_____________________________________________________________________________________________________
		Code Snippet:
			Simple use:
			<select name="combo" id="combo">
			<php 
			echo($crud->fillCombo("SELECT sno,studentName FROM students","sno","studentName"));
			/php>
			</select>
		 	Complex Query use: 
			<select name="combo" id="combo">
			<php 
			$ary = array(":sno"=>12,":classId"=>'10th');
			echo($crud->fillCombo("SELECT sno,studentName FROM students WHERE sno = :sno AND classId = :classId","sno","studentName",$ary));
			/php>
			</select>
		  ____________________________________________________________________________________________________*/
						
		public function fillCombo($sql,$valueMember,$displayMember,$bindVars=array(),$showEmptyFld='1'){
		 try{
			    $this->connect();
			    $options = "";
				$statement = $this->con->prepare($sql);
				$statement->execute($bindVars);				
				 if($statement->rowCount() > 0){
					if($showEmptyFld == 1){
						$options .= '<option value=""></option>';
						}
					foreach($statement as $row) {
						$options .= '<option value="'.$row[$valueMember].'"> '. $row[$displayMember] .' </option>'.PHP_EOL;
						}					
					}
					return $options;
					$this->con = null;
			 }catch(PDOException $exc){ 
				 return $exc->getMessage(); //Developer Machine: Display Exceptions in browser
				}
		 	}				
		
	
		/**
                 * ______________________________________________________________________________________________________
		dateDif($futureDate,$pastDate) function takes two @params as 
			1- $futureDate And $pastDate: coming next full date date('2014-01-02','2014-01-01') 
				Result: "1" it is 1 day
			This function return number of days between past and future date 
		_____________________________________________________________________________________________________
		Code Snippet:
			Difference between two date are in days: <php echo(dateDif('2014-01-02','2014-01-01')); /php>
		    Output: 1 (day)
		  __________________________________________________________________________________________________*/
		
		public function dateDif($futureDate,$pastDate){
			try{
					$this->connect();
					$sql = "SELECT DATEDIFF('".$futureDate."','".$pastDate."') AS diffirence";
					$statement = $this->con->prepare($sql);
					$statement->execute();
					return $statement->fetchColumn();
					$this->con = null;				
				}catch(PDOException $exc){
					return $exc->getMessage();
				}
			}
		
		/**
                 * 	getNumChars($txt,$numChars,$side='L') function takes three @params as 
			1- $txt: sample text
			2- $numChars : need to returns number of character from text
			3- $side : 
				1- 'L' = Read from left to right (Default @Param is from left to right)
				2- 'R' = Read from right to left
		_____________________________________________________________________________________________________
		Code Snippet:
			Read From Left to Right 10 chars: <php echo(getNumChars('This is my sample text in first param',10,'L')); /php>
		    	Output: "This is my" (including spaces)
			Read From Right to Left 10 chars: <php echo(getNumChars('This is my sample text in first param',10,'R')); /php>
				Output: "irst param" (including spaces)
		  __________________________________________________________________________________________________*/
		
		public function getNumChars($txt,$numChars,$side='L'){
			try{
					$this->connect();
					$sql = "SELECT ";
						if($side == 'L'){ $sql .=" LEFT"; }else{ $sql .=" RIGHT"; }
						$sql .= "('".$txt."',".$numChars.") AS txt";
						$statement = $this->con->prepare($sql);
						$statement->execute();
						return $statement->fetchColumn();
						$this->con = null;				
				}catch(PDOException $exc){
					return $exc->getMessage();
				}
			}
		
		/**
                 * get number of words from table column
                 */
		function numWords($table_name,$col_name,$num_words,$isWhere='0',$sno=''){
			try{
				$this->connect();
				$bindVarSno = array();
				$sql = "SELECT SUBSTRING_INDEX(".$col_name.",' ',".$num_words.") as words FROM ".$table_name;
				if($isWhere == '1' && $sno != ''){
					$bindVarSno = array(':sno'=>$sno);
				 	$sql .=" WHERE sno = :sno";
					}
					return $this->getValue($sql,$bindVarSno);
					$this->con = null;
				}catch(PDOException $exc){
					return $exc->getMessage();
					}
			}
		
		/**
                 * this function will initiate beginTransaction() and will commit after finishing querying 
		the tables successfully, while it will not save / commit any changes made via any query if there
		is any error occur in any query, means rollback() will occur in catch() block*/
		public function dbTransaction($sqlsArray= array()){
			$flag = false;
			try{
				if(isset($sqlsArray) && !empty($sqlsArray)){
					$this->connect();
					$this->con->beginTransaction();
					foreach($sqlsArray as $sql=>$ary){//loop over sql Array to get individval sql
						$stmt = $this->con->prepare($sql);
						$stmt->execute($ary);
                                                //$this->tempVar .= 'Sql = '.$sql.' param = '.$ary.'<hr>';
					}					
					$this->con->commit();
					$flag = true;
				}				
			}catch(PDOException $exc){
				$this->con->rollBack();
				$this->tempVar = $exc->getTraceAsString();	
				$this->tempVar .= '<hr>'.$exc->getMessage();
				$flag = false;
			}
			$this->con = null;
			return $flag;
		}
		/**
                 * hitCounter() function takes no @params 
			This function simply checks if session is not already started it will start session
			Then if user first time visiting this web site it will increment value in table
		_____________________________________________________________________________________________________
		Code Snippet:
			Total Hits: <php echo(hitCounter()); /php>
		  ____________________________________________________________________________________________________*/
				
		public function getHitCounter(){
			try{
				$this->connect();
				 $singleIncrement = array(':num'=>'1');
				 $oldVal = $this->getValue("SELECT hits FROM hit_counter");
                                 $oldVal = isset($oldVal) && !empty($oldVal) ? $oldVal:0;
				 if(!isset($_SESSION['counter']) || $_SESSION['counter'] == FAlSE || empty($_SESSION['counter'])){
					 if($oldVal < 1){
						 $this->dbQuery("UPDATE hit_counter SET hits = :num",$singleIncrement);
						 $_SESSION['counter'] = TRUE;
						 }
					 else {
						  $this->dbQuery("UPDATE hit_counter SET hits = hits + 1");
						  $_SESSION['counter'] = TRUE;
						 } 
					 }
					$totalHits = $this->getValue("SELECT hits FROM hit_counter");
                                        if($totalHits < 9){
                                            $totalHits = '00000000'.$totalHits;
                                        }
                                        else if($totalHits < 100){
                                            $totalHits = '0000000'.$totalHits;
                                        }
                                        else if($totalHits < 1000){
                                            $totalHits = '000000'.$totalHits;
                                        }
                                        else if($totalHits < 10000){
                                            $totalHits = '00000'.$totalHits;
                                        }
                                        else if($totalHits < 100000){
                                            $totalHits = '0000'.$totalHits;
                                        }
                                        else if($totalHits < 1000000){
                                            $totalHits = '000'.$totalHits;
                                        }
                                        else if($totalHits < 10000000){
                                            $totalHits = '00'.$totalHits;
                                        }
                                        else{
                                            $totalHits = '0'.$totalHits;
                                        }
                                        return $totalHits;
					$this->con = null;
			}catch(PDOException $exc){
				return $exc->getMessage();
				}
		 }		

                /**
                 * secure search method
                 */
		function secureInput($ary = array()){
			try{
			$securedArray = array();
			foreach($ary as $val){
					$val = str_replace("'","",$val);
					$val = str_replace("#","",$val);
					$val = str_replace("~","",$val);
					$val = str_replace("!","",$val);
					$val = str_replace("%","",$val);
					$val = str_replace("*","",$val);	
					$val = str_replace("$","",$val);
					$val = str_replace("<","",$val);
					$val = str_replace(">","",$val);
					$val = str_replace("drop","",strtolower($val));
					$val = str_replace("show","",strtolower($val));
					$val = str_replace("insert","",strtolower($val));
					$val = str_replace("create","",strtolower($val));
					$val = str_replace("update","",strtolower($val));
					$val = str_replace("select","",strtolower($val));
					$val = str_replace("or","",strtolower($val));
					$val = str_replace('"',"",$val);
					$val = str_replace("+","",$val);
					$val = str_replace(";","",$val);
					$securedArray[] = strip_tags($val);
					}
				}catch(Exception $exc){
					return $exc->getMessage();
					}
					return $securedArray;
			}	
			
	  /**
           * function to securely login to the system
           */
 	  function secureLogin($ary = array()){
		  try{
			  $securedArray = array();
			  foreach($ary as $val){
				$val = str_replace("'","",$val);
				//$val = str_replace("%","",$val);
				$val = str_replace("drop ","",strtolower($val));
				$val = str_replace("show ","",strtolower($val));
				$val = str_replace("insert ","",strtolower($val));
				$val = str_replace("create ","",strtolower($val));
				$val = str_replace("update ","",strtolower($val));
				$val = str_replace("select ","",strtolower($val));
				$val = str_replace("or ","",strtolower($val));
				$val = str_replace('"',"",$val);
				$val = str_replace(";","",$val);
				$securedArray[] = strip_tags($val);
				}
			}catch(Exception $exc){
					return $exc->getMessage();
					}
				 return $securedArray;
     	 	}	
	
		 	
	}
?>
