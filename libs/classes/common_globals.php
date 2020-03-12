<?php //SG class provides a very quick static methods to return website's required Paths, URL etc
class SG{
	public $sgVar;
	public static $para_class = ' style="line-height:40px !important;border:1px solid #07BC21;padding:6px;border-radius:5px;font-family:"book antiqua";font-size:14px;"';
	public static $casetitle_class = ' style="text-align:center;text-decoration:underline;color:#E30A0D;font-family:"book antiua";font-size:20px;"';
	//this method will return only the base url of the website like : 
	//http://xyz.com/sub_dir/sub_dir/index.php => will be http://xyz.com
	public static function getBaseUrl(){
			try{
				if(isset($_SERVER['HTTPS'])) {
					return 'https://'.$_SERVER['SERVER_NAME'];
					} 
				else {
					return 'http://'.$_SERVER['SERVER_NAME'];
					}
				}catch(Exception $exc){
					$sgVar = $exc->getMessage();  
					return false;
					}
			}
        //get base url by passing parameter like this: echo($_SERVER['SERVER_NAME']);
        public static function getUrl($url){
            try {
                $ary = parse_url($url);
                return $ary['path'];
            } catch (Exception $exc) {
                $sgVar = $exc->getMessage();
                return false;
            }
                }
	//get name of the page in the url e.g: http://xyz.com/sub_dir/sub_dir/etc/index.php => index.php
	public static function getPageName(){
		try{
			 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
			}catch(Exception $exc){
				$sgVar = $exc->getMessage();  
				return false;
				}
		}

	//map the modules url path
	public static function getMapPath($modNo=3){//by default the MapPath will be held for institution branch
		try{
			$sub_path = "";
			switch($modNo){
				case 2:
					$sub_path = '/mod/PATH_TO_ADMIN_PANEL/';
					break;
				case 3:
					$sub_path = "/mod/branches/PATH_TO_ANY_OTHER_BRANCH/";
					break;
                                default: 
                                        $sub_path = "";
                                    break;
				}
				return SG::getBaseUrl().$sub_path;
			}catch(Exception $exc){
				$sgVar = $exc->getMessage();  
				return false;
			}
		}
		
	//get full url of the page i.e. 
	//http://xyz.com/sub_dir/sub_dir/index.php will be returned as http://xyz.com/sub_dir/sub_dir/index.php
	public static function getUrlMod(){
		try{
		   $pageURL = 'http';
			   $pageURL .= "://";
			   if($_SERVER["SERVER_PORT"] != "80") {
				  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				  }
			   else {
				  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				  }
				  return $pageURL;
			}catch(Exception $exc){
			$sgVar = $exc->getMessage();  
			return false;
			}
		}
	//create parameterized static function for bootstrap panels to start 
	//parameter list: $panelOpt = 'p'|'d'|'dd'|'s' => p=primary, d=danger, dd=default, s=success
	public static function startPanel($panelOpt='p',$panelHeading="",$icon="",$cssClass=""){
		try{
			$panelOption = "";
			switch($panelOpt){
				case 'p':
						$panelOption = "panel-primary";
					break;
				case 'd':
						$panelOption = "panel-danger";
					break;
				case 'dd':
						$panelOption = "panel-default";
					break;
				case 's':
						$panelOption = "panel-success";
					break;
				default:
						$panelOption = "panel-default";
					break;
				}
				if(isset($icon) && !empty($icon) && !ctype_space($icon)){
					$icon = "<span class='glyphicon glyphicon-".$icon."'></span>";
					}
				$panel = '
							<div class="panel '.$panelOption.'">
								<div class="panel-heading">'.$icon.' '.$panelHeading.'</div>
								<div class="panel-body '.$cssClass.'">							
						';
					echo($panel);
			}catch(Exception $exc){
			$sgVar = $exc->getMessage();  
			return false;	
			}		
		}
	//function to end the above panel 
	public static function endPanel(){
		try{
			echo("</div></div>");
			}catch(Exception $exc){
			$sgVar = $exc->getMessage();  
			return false;
			}
		}
	//check if session has not started in page then start
	public static function handle_session(){
		try{
			if(session_status() == PHP_SESSION_NONE) {
					session_start();
				}
			}catch(Exception $exc){
			$sgVar = $exc->getMessage();  
			return false;	
			}
		}
}//end of class
