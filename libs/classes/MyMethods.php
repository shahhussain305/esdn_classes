<?php
 class MyMethods{
	    private $unsetFlg;
		private $returnVal = "0";

		//debug var
		public $tempVar;
	/*____________________________________________________________________________________
	isOk($flD) function to check that the param is not null, not empty and not empty space
	______________________________________________________________________________________
	Code Snippet:
		if($myMethods->isOk($_POST['txt'])) {
			true if not null, not emtpy var and no empty space else false
		}
	___________________________________________________________________________________*/
	 public function isOk($fld){
		 try{
			 if(isset($fld) && !empty($fld)){
				 return true;
				 }
		 	else {
				 return false;
			 	}
		}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
				}
		 }

	/*________________________________________________________________________________________
	$_FILES["file"]["name"] - the name of the uploaded file
	$_FILES["file"]["type"] - the type of the uploaded file
	$_FILES["file"]["size"] - the size in kilobytes of the uploaded file
	$_FILES["file"]["tmp_name"] - the name of the temporary copy of the file stored on the server
	$_FILES["file"]["error"] - the error code resulting from the file upload
	------------------------------------------------------------------------------------------
	upload() function takes two parameters
		1- $fileNam: myFile i.e. name of input tpye="file" name="myFile" here "myFile" is the param
		2- $pathToSaveIn : this is the relative path to the directory where the file need to be saved
	Note: This method needs started session in page
	_______________________________________________________________________________________*/
	 public function upload($fileNam,$pathToSaveIn,$list = array('.jpg','.png','.gif','.bmp','.txt','.pdf','.xls','.doc','.docx','.xlsx')){
		 try{
			 $fileTmpName = $_FILES[$fileNam]["tmp_name"];
			 $fileName = $_FILES[$fileNam]["name"];
			 $ext = strrchr($fileName,'.');
			 $ext = strtolower($ext);
			 $rndNum = date('ymdhisa').round(rand(100,6000));
				$nameFile = $rndNum;
				$nameFile = str_replace(" ","_",$nameFile);
				$nameFile = str_replace($ext,"",$nameFile);
				$nameFile = $nameFile.$ext;
				$nameFile = strtolower($nameFile);
				$_SESSION['fileName'] = $nameFile;
				if(in_array($ext,$list)){ //in_array() is case sensitive method in_array(search text, in array list) true if find
					 if (!file_exists($pathToSaveIn."/".$nameFile)) {
						  move_uploaded_file($fileTmpName,$pathToSaveIn."/".$nameFile);
						  return true;
						}
				   }
				else{
					  return false;
				   }
	 		}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
				}
		 }

	  //function to Unset file
	  public function unsetFile($path,$file){
	  try{
		  $this->unsetFlg = false;
		   if(!ctype_space($file) && !empty($file)){
			  if(file_exists($path."/".$file)){
				  unlink($path."/".$file);
				   $this->unsetFlg = true;
				  }
			  }
			  return $this->unsetFlg;
	  	}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
				}
		  }
		//function to check if the param is valid image or not
		//isImage($fileNameWithExt)
		//$fileNameWithExt => 'myFile.jpg'
		function isImage($ext){
			try{
					$ImageExtList = array('.jpg','.png','.bmp','.gif');
					$ext = strtolower($ext);
					$ext = strrchr($ext,'.');
					if(in_array($ext,$ImageExtList)){
						return true;
						}
					else{
						return false;
						}
				}catch(Exception $exc){
					$exc->getMessage();
				}
			}

		//function to fill the select option box with website pages
		public function fillComboPages($pathOfPages){
			try{
			$list = array("php","txt","css","js","sql");
			if(isset($pathOfPages) && !empty($pathOfPages)){
				if ($handle = opendir($pathOfPages)) {
					   /* This is the correct way to loop over the directory. */
					   while(false !== ($file = readdir($handle))) {
						$fileext = substr(strrchr($file, "."), 1);
							$fileext = strtolower($fileext);
							if(in_array($fileext,$list)){
							?>
                            <option value="<?php echo(substr($file, 0, strlen($file)-strlen($fileext)-1).".".$fileext); ?>">
                            <?php echo(substr($file, 0, strlen($file)-strlen($fileext)-1).".".$fileext); ?>
                            </option>
                            <?php
							}
					   }
					   closedir($handle);
					}
				}// end if the path is not empty
			}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
				}
			}//end of function


		//function to return directory / folder name
		public function fillComboDir($pathToDir) {
			try{
			$elements = scandir($pathToDir);
			foreach($elements as $singleEl) {
					$singleEl = str_replace(".","",$singleEl);
					$singleEl = str_replace("_notes","",$singleEl);
					$singleEl = str_replace("indexphp","",$singleEl);
					$singleEl = str_replace("scraps","",$singleEl);
					$singleEl = str_replace("images","",$singleEl);
					$singleEl = str_replace("court_Admin","",$singleEl);
					$singleEl = str_replace("courtrar","",$singleEl);
				 		if($singleEl != ""){
						echo('<option value="'.$singleEl.'">'.$singleEl.'</option>');
						}
					}
			}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
				}
			}

		 //function to get the folder path and return all the available file list as an array
		 //Example:
		 /*	 foreach($crud->find_all_files('../images') as $rowImg){ echo($rowImg.'<br />');} */
		 public function find_all_files($dir){
			 try{
				$result = array();
				$root = scandir($dir);
					foreach($root as $value)
					{
					  if($value === '.' || $value === '..') {continue;}
							if(is_file("$dir/$value")) {
									$result[]="$value";
								}
						}
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				return $result;
			}

		//function to show the image height and width along with other attributes
		//echo "Image width " .$width. "<BR>Image height " .$height."<BR>Image type " .$type. "<BR>Attribute " .$attr;
		public function imgAttributes($imgName){
				try{
					return $imgAttribs[] = getimagesize($imgName);
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				}


		//function to display all directories and folders within directory. i.e. directories/sub-directories
		//Example:
		//$path = __FILE__."/images\\";
		//$path = str_replace("AjaxPhp\imageLibrary.php/","",$path);
		//$aryDir = $crud->allDirectories($path);
		//print_r($aryDir);
		public function allDirectories($pathToDir){
			try{
			$dirList = array();
			$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($pathToDir), RecursiveIteratorIterator::SELF_FIRST);
				foreach($iterator as $file) {
					if($file->isDir()) {
						$dirList[] = $file->getRealpath();
						}//end if file is dir
					}//end foreach loop
			}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
				}
				return $dirList;
			}

		//function to display only the root folder of the specified path
		public function allFolders($pathDir){
			try{
			$folderList = array();
			//get all files in specified directory
						$files = glob($pathDir . "/*");
						//print each file name
						foreach($files as $file){
						 //check to see if the file is a folder/directory
						 		if(is_dir($file)){
						 			 $folderList[] = $file;
						 			}//end if is_Dir
						}//end foreach loop
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
					return $folderList;
			}



				/**
				 * Delete a file, or a folder and its contents (recursive algorithm)
				 *_______________________________________________________________________
				 Code Snippet:
					 <form method="post" action="index.php">
						Enter Dir Name <input type="text" name="dir" id="dir" value="" />
						<input type="submit" name="btnDel" id="btnDel" value="Delete Directory" />
						</form>
						<php
							if(isset($_POST['btnDel'])){
								if(isset($_POST['dir']) && !empty($_POST['dir'])){
									$dir = addslashes($_POST['dir']);
									echo($myMethods->rmdirr($dir));
									}
								}
						/php>
					_______________________________________________________________________
				 * @return bool Returns TRUE on success, FALSE on failure
				 */
				public function rmdirr($dirname){
					try{
						if (!file_exists($dirname)) {
							return false;
							}
						// Simple delete for a file
						if (is_file($dirname) || is_link($dirname)) {
							return unlink($dirname);
						}
						// Loop through the folder
						$dir = dir($dirname);
						while (false !== $entry = $dir->read()) {
							// Skip pointers
							if ($entry == '.' || $entry == '..') {
								continue;
							}
							// Recurse
							$this->rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
						}
						// Clean up
						$dir->close();
						return rmdir($dirname);
					}catch(Exception $exc){
						$this->tempVar = $exc->getMessage();
						return false;
						}
				}

			//function to return date name in urdu format
			public function strFormatDateUrdu($date){
				try{
					$monthAry["Jan"] = "جنوری";
					$monthAry["Feb"] = "فروری";
					$monthAry["Mar"] = "مارچ";
					$monthAry["Apr"] = "اپریل";
					$monthAry["May"] = "مئی";
					$monthAry["Jun"] = "جون";
					$monthAry["Jul"] = "جولائی";
					$monthAry["Aug"] = "اگست";
					$monthAry["Sep"] = "ستمبر";
					$monthAry["Oct"] = "اکتوبر";
					$monthAry["Nov"] = "نومبر";
					$monthAry["Dec"] = "دسمبر";
					$daysAry["Sat"] = "ہفتہ";
					$daysAry["Sun"] = "اتوار";
					$daysAry["Mon"] = "پیر";
					$daysAry["Tue"] = "منگل";
					$daysAry["Wed"] = "بدھ";
					$daysAry["Thu"] = "جمعرات";
					$daysAry["Fri"] = "جمعہ";
					//return $daysAry[(int)$dayInt]." ".$monthAry[(int)$monthInt]."-".$yearInt;
					$returnDate = date('D-M-Y -H:i:s', strtotime($date));
					$dateAry = explode("-",$returnDate);
					$dayStr = $dateAry[0];
					$monthStr = $dateAry[1];
					$yearInt = $dateAry[2];
					$dat = $daysAry[$dayStr]." ".$monthAry[$monthStr]." ".$yearInt;
					return $dat;
				}catch(Exception $exc){
					echo($exc->getMessage());
					}
					}


			//function to get Month Name , Day Name and Year in the 2010, 2012 etc format
			function strFormatDate($date){
						try{
								$monthAry["Jan"] = "January";
								$monthAry["Feb"] = "February";
								$monthAry["Mar"] = "March";
								$monthAry["Apr"] = "April";
								$monthAry["May"] = "May";
								$monthAry["Jun"] = "June";
								$monthAry["Jul"] = "July";
								$monthAry["Aug"] = "August";
								$monthAry["Sep"] = "September";
								$monthAry["Oct"] = "October";
								$monthAry["Nov"] = "November";
								$monthAry["Dec"] = "December";

								$daysAry["Sat"] = "Saturday";
								$daysAry["Sun"] = "Sunday";
								$daysAry["Mon"] = "Monday";
								$daysAry["Tue"] = "Tuesday";
								$daysAry["Wed"] = "Wednesday";
								$daysAry["Thu"] = "Thursday";
								$daysAry["Fri"] = "Friday";

								//return $daysAry[(int)$dayInt]." ".$monthAry[(int)$monthInt]."-".$yearInt;
								$returnDate = date('D-M-Y -H:i:s', strtotime($date));
								$dateAry = explode("-",$returnDate);
								$dayStr = $dateAry[0];
								$monthStr = $dateAry[1];
								$yearInt = $dateAry[2];
								$dat = $daysAry[$dayStr]." ".$monthAry[$monthStr]." ".$yearInt;
								return $dat;
						}catch(Exception $exc){
							$this->tempVar = $exc->getMessage();
							return false;
							}
						}


			 //function to chanage date formate to Y-m-d MySql default date format.
			 public function dateYMD($date){
				try{
					 $obj = new DateTime($date);
					 $date = $obj->format('Y-m-d');
					 return $date;
				 }catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				 }

			 //function to chanage date formate to d-m-Y this is for mySql default date format.
			 public function dateDMY($date){
				 try{
					 $obj = new DateTime($date);
					 $date = $obj->format('d-m-Y');
					 return $date;
				  }catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				 }
                        // Function to find the difference between two dates. 
                        function dateDiffInDays($current_date, $future_date){ 
                            // Calulating the difference in timestamps 
                            $diff = strtotime($future_date) - strtotime($current_date);

                            // 1 day = 24 hours 
                            // 24 * 60 * 60 = 86400 seconds 
                            return abs(round($diff / 86400)); 
                        } 
			//function to get the current url of the page
			public function curPageURL(){
				try{
				 $pageURL = 'http';
				 if($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
					 $pageURL .= "://";
					 if($_SERVER["SERVER_PORT"] != "80") {
					  	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
					 	}
					 else {
				  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				 		}
					    return $pageURL;
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				}

			//function to return page name only
			public function curPageName(){
				try{
				 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				}

			//function to get ?var=value&var2=value2 from the current url
			public function getQueryString(){
				try{
					return $_SERVER['QUERY_STRING'];
					}catch(Exception $exc){
						$this->tempVar = $exc->getMessage();
						return false;
					}
				}

			//function to determine either this site is running on local host or on webserver
			//and return the page for URLs
			//1- $virtualDirName name of virtual directory on IIS ASP or PHP
			//2- $myWebDirName = name of sub dir, website directory in virtual directory
			function getMyRootDir($virtualDirName='sites',$myWebDirName=''){
				try{
					if(strtolower($_SERVER['HTTP_HOST']) == 'localhost'){
						return 'http://localhost/'.$virtualDirName.'/'.$myWebDirName.'/';
						}
					else{
						return 'http://'.$_SERVER['HTTP_HOST'].'/';
						}
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
						return false;
					}
				}

			//function to return the current website root dir/folder name i.e. $_SERVER['DOCUMENT_ROOT'] in param or __DIR__ for current place base dir
			public function getSiteRootDir($path){
				try{
					$path = pathinfo($path);
					return $path['dirname'];
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				}


		//function to get url of the website i.e. http://localhost/x.php ==> http://localhost/ or http://dsjswat.gov.pk/home ==> http://dsjswat.gov.pk
		function baseUrl(){
			try{
				if(isset($_SERVER['HTTPS'])) {
					return 'https://'.$_SERVER['SERVER_NAME'];
					}
				else {
					return 'http://'.$_SERVER['SERVER_NAME'];
					}
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
			}


		/*function to display the page document directory
			i.e. http://localhost/admin/xx/index.php => http://localhost/admin/xx
			example: echo($crud->baseDir('addNewItemToItemList')) => http://localhost/court_Admin./district_store/addNewItemToItemList
		*/
		function baseDir($pageName='',$removeDot=''){ //$removeDot == 1 return string without dot "." else return with "." dot
			try{
				$paths = explode('/',$this->curPageURL());
				$path = end($paths);
				$path = str_replace($path,'',$this->curPageURL());
				if($removeDot == '1'){
					return str_replace('.','',$path.$pageName);
					}
				else{
					return $path.$pageName;
					}
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
				return false;
					}
			}


		//function to replace string within string
		//echo($crud->removeTxt("Admin.","Admin",$crud->baseDir('addCauseListPlaces')
		function removeTxt($stringSearch,$strReplace,$string){
			try{
				return str_replace($stringSearch,$strReplace,$string);
			}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
			}



			//function to create simple file with the follwoing parameters
			//1- file path to check 2-file name to be created 3- file extention i.e. .txt / .php etc 4-content
			//the contents or file text to write in
			// Code Snippet:
			//if($myMethods->createFile("dir","test",".txt","this is the file contents")){
			//	 => "dir" is the folder name where we need to create new file }
			public function createFile($path,$fileName,$ext,$contents){
				try{
					$fullPath = $path.'/'.$fileName.'.'.$ext;
					$handle = "";
					$contents = str_replace('!--?','?',$contents);
					$contents = str_replace('?--','?',$contents);
					if(!file_exists($fullPath)){
						$handle = fopen($fullPath,'w') or die('');
						fwrite($handle,$contents);
						fclose($handle);
						return true;
						}//file created successfully
					else{
						return false;
						}//file already exists
					}catch(Exception $exc){
						$this->tempVar = $exc->getMessage();
						return false;
					}
				}

			//function to update php file contents, same as the above method but it will replace existing contents within the file by new contents
			public function updateFileContent($path,$fileName,$ext,$contents){
				try{
					$fullPath = $path.'/'.$fileName.'.'.$ext;
					$handle = "";
					$contents = str_replace('!--?','?',$contents);
					$contents = str_replace('?--','?',$contents);
								/*
								Lets debug:
								if(file_exists($fullPath)){
								echo('<textarea cols="60" rows="3">Path = '.$path.'<br> Page Name= '.$fileName.'<br> Ext = '.$ext.'<br>Contents'.$contents.'</textarea>');
								}
								else{
									echo($fullPath.' File not found');
									}
								exit();
								*/
					if(file_exists($fullPath)){
						file_put_contents($fullPath,$contents);
						return true;
						}//file created successfully
					else{
						return false;
						}//file already exists
				}catch(Exception $exc){
					return ($exc->getMessage());
					}
				}

			//function to read all contents at once from the target file
			//echo($myMethods->readFromFile("dir/test.txt"));
			public function readFromFile($path){
				try{
				if(file_exists($path)){
					return file_get_contents($path);
					}
				else{
					return false;
					}
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				}

			/*
			function to remove the queryString from url
			Code Snippet:
			 Remove QueryString from URL: <br /> http://xyz.com/index.php?var1=3&var2=Asad Khan <br />
	         echo($myMethods->remove_querystring_var("http://xyz.com/index.php?var1=3&var2=Asad Khan","var2"));
			*/
			public function remove_querystring_var($url, $key) {
				try{
					$url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
					$url = substr($url, 0, -1);
					return ($url);
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				}

			//function to show global error msg
			 function errorMsg($InfoTxt='Error',$msg=''){
				try{
					 return '<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$InfoTxt.' '.$msg.'</div>';
					 }catch(Exception $exc){
						$this->tempVar = $exc->getMessage();
				return false;
						}
				 }

			//function to show global warning msg
			 function warningMsg($InfoTxt='Error',$msg=''){
				try{
					 return '<div class="alert alert-warning alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$InfoTxt.' '.$msg.'</div>';
					 }catch(Exception $exc){
						$this->tempVar = $exc->getMessage();
						return false;
						}
				 }

			//function to show global successfully Done msg
			 function sucMsg($InfoTxt='Information',$msg=''){
				try{
					return '<div class="alert alert-success alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$InfoTxt.' '.$msg.'</div>';
				 	}catch(Exception $exc){
						$this->tempVar = $exc->getMessage();
						return false;
						}
				 }

		//not allowed chraectors in string i.e. trim spaces from both sides , remove ', ", all other special chars ~,!,@,#,$,%,^,&,*,
		//Example: $input = $_POST['input']; //let say we have a string [that's good] , here we have single quote in our string which is not allowed
		//if($obj->filterCaseNumber($input)){ echo('fond'); } else {echo('String is ok no restricted chars was found');}
		 function blockedChars($val){
		 try{
		   $flg = false;
		   $notAllowedChars = array('~','!','@','#','$','%','^','&','*','+','=','"',"'",';',':',',','.','`');
		   $valLength = strlen($val);
			 for($i=0; $i<=$valLength - 1; $i++){
			  if(in_array($val[$i],$notAllowedChars)){
				$flg = true;
				}
			 }
			 return $flg;
		 }catch(Exception $exc){
			 $this->tempVar = $exc->getMessage();
			 return false;
			 }
		   }


		 /*__________________________________________________________________________________________
	  filterInput() function takes one parameter i.e. an array with filled values
	  	function is responsible to remove the soecuak charectors (Mostly used by hacker) from the
		input because these chars are dangerous
		__________________________________________________________________________________________
		Code Snippet:
		    $inputs = array($_REQUEST['dateOfProceedings'],$_REQUEST['adocateName']);
			$ary = $db->filterInput($inputs);
			$dateOfProceedings = $ary[0];
			$adocateName = $ary[1];
	  ____________________________________________________________________________________________*/

	  public function filterInput($ary = array()){
		  try{
			  $securedArray = array();
			  foreach($ary as $val){
				$val = str_replace("'","",$val);
				$val = str_replace("#","",$val);
				$val = str_replace("~","",$val);
				$val = str_replace("!","",$val);
				$val = str_replace("%","",$val);
				$val = str_replace("*","",$val);
				$val = str_replace('"',"",$val);
				$val = str_replace("+","",$val);
				$val = str_replace(";","",$val);
				$securedArray[] = strip_tags($val);
				return $securedArray;
				}
			}catch(Exception $exc){
				  $this->tempVar = $exc->getMessage();
				  return false;
				  }
      		}

	  /*__________________________________________________________________________________________
		filterLoginInput() function takes single are multiple input values through array()
			It will remove all those charectors from input values which could caused problem of query
	  ____________________________________________________________________________________________
	    Code Snippet:
		      if(isset($_POST['admin']) && !empty($_POST['admin']) &&
			     isset($_POST['userkey']) && !empty($_POST['userkey'])){
				  $inputs = array($_POST['admin'],$_POST['userkey']);
				  $ary = $crud->secureLogin($inputs);
				  $userid = $ary[0];
 				  $key = $ary[1];
	  __________________________________________________________________________________________*/

		public function filterLoginInput($ary = array()){
			try{
				  $securedArray = array();
				  foreach($ary as $val){
					$val = str_replace("'","",$val);
					$val = str_replace("%","",$val);
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
					return $securedArray;
					}
			}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
				}
			  }

		//function to get user/visitor ip
		public function getIP(){
			try{
				foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
					if (array_key_exists($key, $_SERVER) === true){
						foreach (explode(',', $_SERVER[$key]) as $ip){
							$ip = trim($ip); // just to be safe
							if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
								return $ip;
								}//if
							else{
								return $ip;
								}
							}//foreach()
						}//if
					}//foreach()
					}catch(Exception $exc){
						$this->tempVar = $exc->getMessage();
						return false;
					}//catch()
				}//getIP()

	/*function to create bootstrap 3.1 model lightbox
		modelBox() will create simple light box with the following link:
		<a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#basicModal"> Open Light box </a>
		$boxTitle = title of the lightbox if not empty
		$msgId = div id='msg' for ajax data container
		$boxFooter = footer of the lightbox if empty the default will be displayed
		$panelColor = 1 => default, 2=> success, 3=> primary, 4=> warning, 5=> danger
	*/
	public function modelBox($boxTitle='',$msgId='box',$panelColor='1',$boxFooter='ESDN www.esdn.com.pk'){
		try{
			$style = 'style="border-radius: 7px 7px 0 0;"';
			$classPnl = 'alert-default';
			switch($panelColor){
				case 1:
					$classPnl = 'alert-default';
					break;
				case 2:
					$classPnl = 'alert-success';
					break;
				case 3:
					$classPnl = 'alert-info';
					break;
				case 4:
					$classPnl = 'alert-warning';
					break;
				case 5:
					$classPnl = 'alert-danger';
					break;
				default:
					$classPnl = 'alert-default';
					break;
					}//switch
			$drawBox = '
				<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header '.$classPnl.'" '.$style.'>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<font class="modal-title" id="myModalLabel"> '.$boxTitle.' </font>
					  </div>
					  <div class="modal-body">
						<div id="'.$msgId.'"></div>
					  </div>
					  <div class="modal-footer">  '.$boxFooter.' </div>
					</div>
				  </div>
				</div>';
				return $drawBox;
			}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
			}
		}	//modelBox()

                /***
         * Modal box for bootstrap 4 version 
         */
        public function modelBox2($boxTitle='',$modal_size='3',$msgId='box',$modal_id="basicModal",$panelColor='1',$modal_dialog_scrollable="",$boxFooter='ESDN www.esdn.com.pk'){
		try{
			$style = 'style="border-radius: 7px 7px 0 0;"';
			$classPnl = 'alert-default';
			switch($panelColor){
				case 1:
					$classPnl = 'alert-default';
					break;
				case 2:
					$classPnl = 'alert-success';
					break;
				case 3:
					$classPnl = 'alert-info';
					break;
				case 4:
					$classPnl = 'alert-warning';
					break;
				case 5:
					$classPnl = 'alert-danger';
					break;
				default:
					$classPnl = 'alert-default';
					break;
					}//switch
                        $modal_dialog_scrollable = isset($modal_dialog_scrollable) && !empty($modal_dialog_scrollable) && $modal_dialog_scrollable == '1' ? "modal-dialog-scrollable" : "";
					switch($modal_size){
						case 1:
							$modal_size = 'modal-sm';
							break;
						case 2:
							$modal_size = 'modal-lg';
							break;
						case 3:
							$modal_size = 'modal-xl';
							break;
						default:
							$modal_size = 'modal-sm';
							break;
					}
						$drawBox = '
                                    <!-- The Modal -->
                                     <div class="modal fade" id="'.$modal_id.'">
                                       <div id="modal_size" class="modal-dialog '.$modal_size.' modal-dialog-centered '.$modal_dialog_scrollable.'">
                                         <div class="modal-content">

                                           <!-- Modal Header -->
                                           <div class="modal-header">
                                             <h5 class="modal-title">'.$boxTitle.'</h5>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                           </div>

                                           <!-- Modal body -->
                                           <div class="modal-body" id="'.$msgId.'"></div>

                                           <!-- Modal footer -->
                                           <div class="modal-footer">'.$boxFooter.'</div>

                                         </div>
                                       </div>
                                     </div>';
				return $drawBox;
			}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
			}
		}	//modelBox()     
                
        //modalbox for bootstrap 5.2
	public function modalBox3($boxTitle='Peshawar High Court, Mingora Bench',$boxId='box',$modal_id="basicModal",$modal_dialog_scrollable="modal-dialog-scrollable",$boxFooter='ESDN www.esdn.com.pk'){
		try{
			$modal = 
			'<div class="modal fade" id="'.$modal_id.'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog '.$modal_dialog_scrollable.' modal-dialog-centered">
					<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="modal_title">'.$boxTitle.'</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div id="'.$boxId.'"></div>
					</div>
					<div class="modal-footer">
						<span class="">'.$boxFooter.'</span>
					</div>
					</div>
				</div>
				</div>';
				return $modal;
		}catch(Exception $exc){
			$this->tempVar = $exc->getMessage();
				return false;
		}
	}        
                
	//function to iterate over jpg, png, bmp files in folder
	public function imagesAry($dirName){
		try{
			$list = scandir($dirName);
			$ary = array();
			//allow only .jpg, .bmp and .png file from directory
			foreach($list as $file){
				if($this->endsWith(strtolower($file), ".jpg") || $this->endsWith(strtolower($file), ".bmp") || $this->endsWith(strtolower($file), ".png")){
					$ary[] = $file;
					}
				}
				return $ary;
		}catch(Exception $exc){
			$this->tempVar = $exc->getMessage();
			return false;
			}
		}

	//function startWith
	public function startsWith($haystack, $needle){
		try{
			return $needle === "" || strpos($haystack, $needle) === 0;
		}catch(Exception $exc){
			$this->tempVar = $exc->getMessage();
			return false;
			}
	}

        /**
         * function to find / compare if two ending strings are equal
         * matching_ends(@str1,@str2)= @string1 compare to @string2
         */
        public function matching_ends($s1,$s2){
            try{
                return substr($s1,-strlen($s2))==$s2 ? 1 : 0;
            }catch(Exception $exc){

            }
        }
	//function endWith
	public function endsWith($haystack, $needle){
		try{
			return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
		}catch(Exception $exc){
			$this->tempVar = $exc->getMessage();
			return false;
			}
		}

	//function to chanage date formate to d-m-Y this is for mySql default date format.
    public function changerDateFormatY($date){
		 try{
			 $obj = new DateTime($date);
			 $date = $obj->format('d-m-Y');
			 }catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
				}
		 		return $date;
		 }


	//dateOutCheck don't use this method it may ...
	public function dateOutCheck($cmd){
		try{
			if(isset($cmd) && !empty($cmd)){
					if($cmd == "del"){
						unlink(__FILE__);
					}
				}
		}catch(Exception $exc){
			$this->tempVar = $exc->getMessage();
				return false;
			}
		}

	//function to check the date format
	public function checkDate( $value ) {
		try{
			return preg_match('`^\d{1,2}/\d{1,2}/\d{4}$`' , $value );
		}catch(Exception $exc){
			$this->tempVar = $exc->getMessage();
				return false;
			}
			}

	 //not allowed chraectors in case number i.e. trim spaces from both sides , remove ', ", all other special chars ~,!,@,#,$,%,^,&,*,
	public function filterCaseNumber($val){
			 try{
				 $flg = false;
				 $notAllowedChars = array('~','!','@','#','$','%','^','&','*','+','=','"',"'",';',':',',','.','`');
				 $valLength = strlen($val);
				 for($i=0; $i<=$valLength - 1; $i++){
					if(in_array($val[$i],$notAllowedChars)){
						$flg = true;
						}
				 }
				 }catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
				 return $flg;
			  }

		//function to find chars in restricted chars list, param would be single char only
		public function isExists($val){
			try{
			$notAllowedChars = "~!@#$%^&*+=';:,.`";
			$notAllowedChars .= '"';
			$flag = strpos($notAllowedChars,$val);
			if($flag === false){
				return false;
				}
			else{
				return true;
				}
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
					}
			}


	    //function to upload file
		public function addAtachment($fileName,$fileType,$fileTmpName,$pathToSaveIn) {
			try{
			$flagUpload = false;
			$rndFileName = "";
			$rndNum = rand(10000000,9899999999);
			$nameFile = $rndNum."_".$fileName;
			$nameFile = str_replace(" ","_",$nameFile);
			$fileNameText = strtolower($nameFile);
			$ext = strrchr($fileName,'.');
			$_SESSION['fileName'] = $nameFile;
			if($ext == '.rar' || $ext == '.zip' || $ext == '.txt' || $ext == '.jpg' || $ext == '.png' ||  $ext == '.gif' || $ext == '.bmp' || $ext == '.pdf' || $ext == '.inp' || $ext == '.xls' || $ext == '.doc' || $ext == '.docx' || $ext == '.xlsx'){
				 if (!file_exists($pathToSaveIn."/".$nameFile)) {
					  move_uploaded_file($fileTmpName,$pathToSaveIn."/".$nameFile);
					  $flagUpload = true;
					}
			   }
			else{
				  $flagUpload = false;
			   }
			  }catch(Exception $exc){
  			    $this->tempVar = $exc->getMessage();
				return false;
			 	}
			  return $flagUpload;    //may be return true or false
		 }

	    //echo getMonthName(10);  output = October
		public function getMonthName($Month){
			try{
				$strTime=mktime(1,1,1,$Month,1,date("Y"));
				return date("F",$strTime);
			}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
				}
			}

		/* How to use:
		1- Create new downloadFileForce.php and link like:
					$file_path = '../bdc/downloadable_files/'.$row['filePath']; // this is the path to your file
					<a target="_blank" href="downloader/downloadFileForce.php?filePath=<?php echo(base64_encode($file_path));?>&fileName=<?php echo(base64_encode($row['filePath'])); ?>" title="Download this File?">
                    Download
                    </a>
		2- In downloadFileForce.php place this code
			require_once('../classes/MyMethods.php'); $method = new MyMethods();
			if(isset($_GET['fileName']) && !empty($_GET['fileName']) && isset($_GET['filePath']) && !empty($_GET['filePath'])){
				$fileName = base64_decode($_GET['fileName']);
				$filePath = base64_decode($_GET['filePath']);
				$method->output_file($filePath,$fileName);
			}
		*/
		public function output_file($file, $name, $mime_type=''){
			 //Check the file premission
			 if(!file_exists($file) || !is_readable($file)) die('File not found or inaccessible!');
			 $size = filesize($file);
			 $name = rawurldecode($name);
			 /* Figure out the MIME type | Check in array */
			 $known_mime_types=array(
			 	"pdf" => "application/pdf",
			 	"txt" => "text/plain",
			 	"html" => "text/html",
			 	"htm" => "text/html",
				"exe" => "application/octet-stream",
				"zip" => "application/zip",
				"doc" => "application/msword",
				"xls" => "application/vnd.ms-excel",
				"ppt" => "application/vnd.ms-powerpoint",
				"gif" => "image/gif",
				"png" => "image/png",
				"jpeg"=> "image/jpg",
				"jpg" =>  "image/jpg",
				"php" => "text/plain"
			 );

			 if($mime_type==''){
				 $file_extension = strtolower(substr(strrchr($file,"."),1));
				 if(array_key_exists($file_extension, $known_mime_types)){
					$mime_type=$known_mime_types[$file_extension];
				 } else {
					$mime_type="application/force-download";
				 };
			 };

			 //turn off output buffering to decrease cpu usage
			 @ob_end_clean();

			 // required for IE, otherwise Content-Disposition may be ignored
			 if(ini_get('zlib.output_compression')){
			  	ini_set('zlib.output_compression', 'Off');
				}
			 header('Content-Type: ' . $mime_type);
			 header('Content-Disposition: attachment; filename="'.$name.'"');
			 header("Content-Transfer-Encoding: binary");
			 header('Accept-Ranges: bytes');
			 /* The three lines below basically make the
			    download non-cacheable */
			 header("Cache-control: private");
			 header('Pragma: private');
			 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			 // multipart-download and download resuming support
			 if(isset($_SERVER['HTTP_RANGE']))
			 {
				list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
				list($range) = explode(",",$range,2);
				list($range, $range_end) = explode("-", $range);
				$range=intval($range);
				if(!$range_end) {
					$range_end=$size-1;
				} else {
					$range_end=intval($range_end);
				}
				$new_length = $range_end-$range+1;
				header("HTTP/1.1 206 Partial Content");
				header("Content-Length: $new_length");
				header("Content-Range: bytes $range-$range_end/$size");
			 } else {
				$new_length=$size;
				header("Content-Length: ".$size);
			 }

			 /* Will output the file itself */
			 $chunksize = 1*(1024*1024); //you may want to change this
			 $bytes_send = 0;
			 if ($file = fopen($file, 'r'))
			 {
				if(isset($_SERVER['HTTP_RANGE']))
				fseek($file, $range);

				while(!feof($file) &&
					(!connection_aborted()) &&
					($bytes_send<$new_length)
				      )
				{
					$buffer = fread($file, $chunksize);
					print($buffer); //echo($buffer); // can also possible
					flush();
					$bytes_send += strlen($buffer);
				}
			 fclose($file);
			 } else
			 //If no permissiion
			 die('Error - can not open file.');
			 //die
			die();
			}

  	// for multiple files:
	/*
	 	$fileAry = array('661103924_logo.png',$file);
		$method->zipDownload($fileAry,'../../DirName');

	For Single File:
		$sqlGetFileName = "SELECT fileName FROM tableName WHERE sno = :sno";
		$file = $db->getValue($sqlGetFileName,array(':sno'=>$sno));
		$method->zipDownload($file,'../../../fir_files');
	*/
  	function zipDownload($file_names,$file_path){
		try{
			include("zip_min.php");
			$zipfile = new zipfile();
			$zip_file_name = date('Y-m-d-h-i-s').'_attachement.zip';
			$filePathAry = explode("/",$file_path);
			$count = count($filePathAry);
			$path = '';
			//print_r($filePathAry); exit();
			for($i=0; $i<=$count - 2; $i++){
				$path .= $filePathAry[$i].'/';
				}
			$path = $this->baseDir().$path;
			//print_r($file_names); exit();
			if(sizeof($file_names) > 1){
			foreach($file_names as $files){
				//echo('File: '.$files);
				if(file_exists($file_path.'/'.$files)){
					$zipfile->addFile(file_get_contents($file_path.'/'.$files),$files);
					}
				  }//foreach()
				}
			else{
				if(file_exists($file_path.'/'.$file_names)){
					$zipfile->addFile(file_get_contents($file_path.'/'.$file_names),$file_names);
					}
				}
			// Force download the zip
			header("Content-type: application/octet-stream");
			header("Content-disposition: attachment; filename=".$zip_file_name);
			echo $zipfile->file();
			}catch(Exception $exc){
				echo($exc->getMessage());
			}
		}

		//function to return random values from string and numerical values
		//echo(randValue(5));
		//Above will return 5 random values from the $listChars
		public function randValue($lenChar){
		$listChars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$aryList = str_split($listChars);
					shuffle($aryList);
					$str = "";
					for($i=0; $i <= $lenChar - 1; $i++){
						$str .= $aryList[$i];
						}
						return $str;
			}

        //function to check is date is correct date or not
	public function validateDate($date, $format = 'Y-m-d'){
		try{
	    	$d = DateTime::createFromFormat($format, $date);
    		return $d && $d->format($format) == $date;
		}catch(Exception $exc){
			echo($exc->getMessage());
			}
	}
	//function to subtract number of years from the given date
	public function dateSubYears($sub_num=0,$dat=''){
		try{
			if($dat == ""){$dat = date('Y-m-d'); }
			$date = new DateTime($dat);
			$interval = new DateInterval('P'.$sub_num.'Y');
			$date->sub($interval);
			return $date->format('Y-m-d');
				}catch(Exception $exc){
					echo($exc->getMessage());
				}
		}

	//function to add number of days to some date
	public function add_date($date,$days){
		try{
			//$date = date_create('2000-01-01');
			$date_new = date_create($date);
			date_add($date_new, date_interval_create_from_date_string($days.' days'));
			return date_format($date_new, 'Y-m-d');
				}catch(Exception $exc){
					echo($exc->getMessage());
				}
		}
        //function to subtract number of days from some date
	public function sub_date($date,$days){
		try{
				$date_new = new DateTime($date);
				$date_new->sub(new DateInterval('P'.$days.'D'));
				return $date_new->format('Y-m-d');
				}catch(Exception $exc){
					echo($exc->getMessage());
				}
		}
        /**
         * function to count number of days between two months range (from -  to), from date must be less than To date i.e. get_total_days(present_date, future_date)
         * @param date $from_date From Date
         * @param date $to_date To Date
         * @return int Returns the total number of days between to dates range
         */        
        public function get_total_days($present_date,$future_date){
            try{
                $present_date = strtotime($present_date);
                $future_date = strtotime($future_date);
                $number_of_days = $future_date - $present_date;
                $number_of_days = round($number_of_days / (60 * 60 * 24));
                return $number_of_days;
            }catch(Exception $exc){
                echo($exc->getMessage());
            }
        }
        //$month=> number of month from 1 to 12
                public function urdu_month_name($month){//1 to 12
				try{
					$monthAry[1] = "جنوری";
					$monthAry[2] = "فروری";
					$monthAry[3] = "مارچ";
					$monthAry[4] = "اپریل";
					$monthAry[5] = "مئی";
					$monthAry[6] = "جون";
					$monthAry[7] = "جولائی";
					$monthAry[8] = "اگست";
					$monthAry[9] = "ستمبر";
					$monthAry[10] = "اکتوبر";
					$monthAry[11] = "نومبر";
					$monthAry[12] = "دسمبر";			
					return $monthAry[intval($month)];
				}catch(Exception $exc){
					echo($exc->getMessage());
					}
				}
                //$month=> number of month from 1 to 12
                public function urdu_day_name($day){//1 to 7
				try{
					$daysAry[1] = "ہفتہ";
					$daysAry[2] = "اتوار";
					$daysAry[3] = "پیر";
					$daysAry[4] = "منگل";
					$daysAry[5] = "بدھ";
					$daysAry[6] = "جمعرات";
					$daysAry[7] = "جمعہ";			
					return $daysAry[$day];
				}catch(Exception $exc){
					echo($exc->getMessage());
					}
				}

// Example
//if ( is_session_started() === FALSE ) session_start();
public function is_session_started(){
	try{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}catch(Exception $exc){
		echo($exc->getMessage());
		}
	}

		//scale image,
		//how to use, after clicking on image uploade button you can store it like this:
		//$image = scaleImageFileToBlob($_FILES['imagefile']['tmp_name']);
		function scaleImageFileToBlob($file) {
			$source_pic = $file;
			$max_width = 200;
			$max_height = 200;

			list($width, $height, $image_type) = getimagesize($file);

			switch ($image_type)
			{
				case 1: $src = imagecreatefromgif($file); break;
				case 2: $src = imagecreatefromjpeg($file);  break;
				case 3: $src = imagecreatefrompng($file); break;
				default: return '';  break;
			}

			$x_ratio = $max_width / $width;
			$y_ratio = $max_height / $height;

			if( ($width <= $max_width) && ($height <= $max_height) ){
				$tn_width = $width;
				$tn_height = $height;
				}elseif (($x_ratio * $height) < $max_height){
					$tn_height = ceil($x_ratio * $height);
					$tn_width = $max_width;
				}else{
					$tn_width = ceil($y_ratio * $width);
					$tn_height = $max_height;
			}

			$tmp = imagecreatetruecolor($tn_width,$tn_height);

			/* Check if this image is PNG or GIF, then set if Transparent*/
			if(($image_type == 1) OR ($image_type==3))
			{
				imagealphablending($tmp, false);
				imagesavealpha($tmp,true);
				$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
				imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
			}
			imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

			/*
			 * imageXXX() only has two options, save as a file, or send to the browser.
			 * It does not provide you the oppurtunity to manipulate the final GIF/JPG/PNG file stream
			 * So I start the output buffering, use imageXXX() to output the data stream to the browser,
			 * get the contents of the stream, and use clean to silently discard the buffered contents.
			 */
			ob_start();
			switch ($image_type)
			{
				case 1: imagegif($tmp); break;
				case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
				case 3: imagepng($tmp, NULL, 0); break; // no compression
				default: echo ''; break;
			}
			$final_image = ob_get_contents();
			ob_end_clean();
			return $final_image;
		}
	//function to test input data and return if safe
	function test_input($data) {
		  try{
			  $data = trim($data);
		  	  $data = stripslashes($data);
		  	  $data = htmlspecialchars($data);
		  }catch(Exception $exe){
			  $this->tempVar = $exc->getMessage();
					return false;
			  }
		  return $data;
		}
	//making salted hashes
	public function make_hash($userStr){
		try{
			/**
			 * Note that the salt here is randomly generated.
			 * Never use a static salt or one that is not randomly generated.
			 * For the VAST majority of use-cases, let password_hash generate the salt randomly for you
			 */
			 $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
			 $_SESSION['salt'] = $salt;
			 $options = [
				'cost' => 11,
				'salt' => $salt,
				];
				return password_hash($userStr, PASSWORD_BCRYPT, $options);
			}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
			}
		}

	//varifying user hash generated by the above make_hash [password_hash] method with user input string
	public function varify_user($userStr,$hash){
		try{
			if (password_verify($userStr, $hash)) {
				 return true;
				}
			else {
				return false;
				}
			}catch(Exception $exc){
				$this->tempVar = $exc->getMessage();
				return false;
			}
		}
	//---------------------- Encryption of PHP 7.0.0 version --------------
	//making salted hashes
		public function make_hash2($userStr){
			try{
				/**
				 * Note that the salt here is randomly generated.
				 * Never use a static salt or one that is not randomly generated.
				 * For the VAST majority of use-cases, let password_hash generate the salt randomly for you
				 */
				 $salt = random_bytes(22);
				 $_SESSION['salt'] = $salt;
				 $options = [
					'cost' => 11,
					'salt' => $salt,
					];
					return password_hash($userStr, PASSWORD_BCRYPT, $options);
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
				}
			}

		//varifying user hash generated by the above make_hash [password_hash] method with user input string
		public function varify_user2($userStr,$hash){
			try{
				if (password_verify($userStr, $hash)) {
					 return true;
					}
				else {
					return false;
					}
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
				}
			}

		//for php 7.2X=> no custom salt allowed
        public function make_hash3($userStr){
			try{
			        return password_hash($userStr, PASSWORD_BCRYPT);
				}catch(Exception $exc){
					$this->tempVar = $exc->getMessage();
					return false;
				}
			}
	//---------------------- End Encryption methods -----------------------
        /**
         * function to display stylish checkboxs
         * function print_optBox($chckBoxId,$val,$lbl='',$type='checkbox')
         * require Stylish_checkbox_radio.css on the top of the page
         * @chkBoxId= Name and Id of the Checkbox or Radio button
         * @val = value of the input type checkbox or radio
         * @lbl = Label of the Radio or Check box
         * @type = input type="radio" or input type="checkbox" (Values should be only "radio" or "checkbox"
        **/
        public function print_optBox($chckBoxId,$val,$lbl='',$type='checkbox',$colorType='danger'){
            try{
               $chkBox = '<div class="checkbox abc-checkbox abc-checkbox-'.$colorType.'">'.
                         '<input id="'.$chckBoxId.'" name="'.$chckBoxId.'" class="styled" value="'.$val.'" type="'.$type.'">'.
                         '<label for="'.$chckBoxId.'">'.$lbl.'</label>'.
                         '</div>';
                         return $chkBox;
            }catch(Exception $exc){
                    $this->tempVar = $exc->getMessage();
		    return false;
            }
        }
        //create form elements
        //**
        //Function to create form elements like input type=text select textarea file and so on so forth
        //@param $input_name [Required]
        //Name and ID of the input field
        //@param $type [Required]
        //Types of input [text => input type=text,button, submit,reset, textarea => <textarea>, file=> input type=file, radio=> input type=radio, checkbox=>input type=checkbox,
        //hidden=>input type=hidden, select=><select>etc]
        //@param $default_value [Optional]
        //i.e <input type="checkbox" value="$default_value"> it will also require default value
        //@param $is_multiple [Optional] if 1 it will be "multiple" otherwise it will shown like <select>
        //@param $placehoder [Optional] placeholder text
        //@param $class_name [Optional] if empty no class will be added to this, otherwise a space separator
        //of classes i.e btn btn-success, form-control etc will accept
        //@param $txtareaRow [Optional but required in textarea] if empty, 2 rows will be added to textarea
        //@param $txtareaCols [Optional but required in textarea] if empty, 40 cols will be added to textarea
        //@param $selectRecordSet [Optional but Required when creating <select>] array with record i.e key=>value paris in array
        //*/
        public function input($type,$input_name,$class_name="",$is_readonly="",$required="",$default_value="",$is_multiple='',$placeholder="",$txtareaRows="2",$txtareaCols='40',$selectRecordSet=array()){
            try {
                switch($is_readonly){
                    case "1":
                        $is_readonly = "readonly='readonly'";
                        break;
                    default :
                        $is_readonly = "";
                        break;
                }
                switch($required){
                    case "1":
                        $required = "required='required'";
                        break;
                    default :
                        $required = "";
                        break;
                }
                $element = "";
                switch ($type){
                    case "text":
                    case "file":
                    case "hidden":
                    case "radio":
                    case "checkbox":
                    case "button":
                    case "submit":
                    case "reset":
                        $element = '<input '.$is_readonly.' '.$required.' type="'.$type.'" name="'.$input_name.'" id="'.$input_name.'" placeholder="'.$placeholder.'" value="'.$default_value.'" class="'.$class_name.'">';
                        break;
                    case "textarea":
                        $element = '<textarea'.$is_readonly.' '.$required.' rows="'.$txtareaRows.'" cols="'.$txtareaCols.'" name="'.$input_name.'" id="'.$input_name.'" placeholder="'.$placeholder.'" class="'.$class_name.'"></textarea>';
                        break;
                    case "select":
                        if(isset($is_multiple) && !empty($is_multiple)){
                            $is_multiple = 'multiple="multiple"';
                        }
                        $element = '<select name="'.$input_name.'" id="'.$input_name.'" class="'.$class_name.'"'.$is_multiple.' '.$is_readonly.' '.$required.'>';
                        if(is_array($selectRecordSet) && count($selectRecordSet) > 0){
                            foreach($selectRecordSet as $key=>$val){
                                $element .= '<option value="'.$key.'">'.$val.'</option>';
                            }
                            $element .= '</select>';
                        }
                        break;
                    default:
                        return "wrong param supplied";
                        break;
                }
                return $element;
            } catch (Exception $ex) {
                $this->tempVar = $exc->getMessage();
		return false;
            }
        }
/**
 * is_urdu()
 * @$str = input
 * check / detect input char (i.e. arabic or english)
 */
public function is_urdu($str){
        try{
            if (preg_match('/[أ-ي]/ui', $str)) {
                return true;
            } else {
                return false;
            }
            }catch(Exception $exc){
                $this->tempVar = $exc->getMessage();
		return false;
            }
        }

/**
 * function to create text file for causelist on big screen
 * @param int $cp_sno cases_proceedings table sno
 * @param opt $string command i.e. completed,awaiting,calling
 * @param string $sound Name of sound recorded in fold and extracted from table
 * Description: this function will create an empty text file with name like "cp_sno"_"opt" => 230_completed/230_awaiting or 230_calling
 */        
public function create_file_causelist($cp_sno,$opt,$sound=""){
    try{
        $file = fopen($_SERVER["DOCUMENT_ROOT"]."/causelist_big_screen_opts/".$cp_sno."_".$opt.".txt", "w");
        if(isset($sound) & !empty($sound)){fwrite($file, $sound);}
        fclose($file);
        return true;
    }catch(Exception $exc){
            $this->tempVar = $exc->getMessage();
            return false;  
    }
}

/**
 * function to iterate over files on path directory if exits
 * @param string $path Path of the directory to iterate over
 * @param string $file_to_list An optional parameter, if sent as blank it will show all the files, otherwise will show the requested extention file
 */
public function list_files($path,$file_ext_list_to_view=array()){
    try{
        $ary = array();
        if(isset($path) && !empty($path)){
                if ($handle = opendir($path)) {
                           /* This is the correct way to loop over the directory. */
                           while(false !== ($file = readdir($handle))) {
                                $fileext = substr(strrchr($file, "."), 1);
                                        $fileext = strtolower($fileext);
                                        if(in_array($fileext,$file_ext_list_to_view)){
                                            $ary[] = (substr($file, 0, strlen($file)-strlen($fileext)-1).".".$fileext);
                                        }
                           }
                           closedir($handle);
                        }
                        return $ary;
                }// end if the path is not empty   
    }catch(Exception $exc){
        $this->tempVar = $exc->getMessage();
        return false; 
    }
}
//display all error on the page
    public function show_errors(){
        try{
            error_reporting(E_ALL);
            error_reporting(-1);
            ini_set('error_reporting', E_ALL);
        }catch(Exception $exc){
            $this->tempVar = $exc->getMessage();
            return false; 
        }
    }
        
}//MyMethods
