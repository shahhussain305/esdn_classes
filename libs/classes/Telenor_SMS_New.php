<?php
class Telenor{
/**
Sends Quick message
*/
   var $tempVar="";
   public function sendSmsMessage($messageText,$toNumbersCsv,$mask='11-digits-registered-MASK'){
       try{
        $urlSession="https://telenorcsms.com.pk:27677/corporate_sms2/api/auth.jsp?msisdn=923xxxxxxxxx&password=password";
        $urlSendSms="https://telenorcsms.com.pk:27677/corporate_sms2/api/sendsms.jsp?session_id=#session_id#&to=#to_number_csv#&text=#message_text#&mask=Mask";
        $sessionKey = "";        
            //$response = simplexml_load_file($urlSession); 
            $response = $this->curl_download($urlSession); 
            if($response && substr($response->response,0,5) !== "Error"){
            $sessionKey = $response->data;
            $url=str_replace("#message_text#",urlencode($messageText),$urlSendSms);
            $url=str_replace("#to_number_csv#",$toNumbersCsv,$url);
            $urlWithSessionKey = str_replace("#session_id#",$sessionKey,$url);
                $xml=$this->curl_download($urlWithSessionKey);
                $returnedResult = $xml->data;
                if(isset($returnedResult) && !empty($returnedResult) && substr($returnedResult,0,5) !== "Error"){
                    $this->tempVar = $xml;
                    return TRUE;
                    }
                else{
                    $this->tempVar = $xml;
                    return FALSE;
                }
            }//if session key was ok
       }catch(Exception $exc){
           $this->tempVar = $xml;
           echo('SMS not sent due to some internal server error.');
       }
    }
/**
Sends Http request to api
*/
    private function sendApiCall($url){
        $response = file_get_contents($url);
        $xml=simplexml_load_string($response) or die("Error: Cannot create object");
        if(isset($xml) && !empty($xml->response)){
        return $xml;
        }
        return "";
    }

    function curl_download($Url){ 
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$Url);
            curl_setopt($ch, CURLOPT_HEADER, false); // no headers in the output
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // output to variable
            curl_setopt($ch, CURLOPT_POST, false);
            $data = curl_exec($ch);
            curl_close($ch);
            echo $data;
        }
    
        function doJob($url){
            try{
                $ch = curl_init(); 
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                $output = curl_exec($ch);
                curl_close($ch);
                return simplexml_load_string($output);
            }catch(Exception $exc){
                
            }
        }
}
