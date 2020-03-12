<?php
class Telenor{
/**
Sends Quick message
*/
   public function sendSmsMessage($messageText,$toNumbersCsv,$mask='11-digits-registered-MASK'){
        $urlSession="https://telenorcsms.com.pk:27677/corporate_sms2/api/auth.jsp?msisdn=923xxxxxxxxx&password=password";
        $urlSendSms="https://telenorcsms.com.pk:27677/corporate_sms2/api/sendsms.jsp?session_id=#session_id#&to=#to_number_csv#&text=#message_text#&mask=Mask";        
        //$urlSession="https://203.99.57.94:27677/corporate_sms2/api/auth.jsp?msisdn=923xxxxxxxx&password=password";
        //$urlSendSms="https://203.99.57.94:27677/corporate_sms2/api/sendsms.jsp?session_id=#session_id#&to=#to_number_csv#&text=#message_text#&mask=Dar-Ul-Qaza";
        $sessionKey = "";        
            $response = simplexml_load_file($urlSession); 
            if($response && substr($response->response,0,5) !== "Error"){
            $sessionKey = $response->data;
            $url=str_replace("#message_text#",urlencode($messageText),$urlSendSms);
            $url=str_replace("#to_number_csv#",$toNumbersCsv,$url);
            $urlWithSessionKey = str_replace("#session_id#",$sessionKey,$url);
                $xml=$this->sendApiCall($urlWithSessionKey);
                $returnedResult = $xml->data;
                if(isset($returnedResult) && !empty($returnedResult) && substr($returnedResult,0,5) !== "Error"){
                    return TRUE;
                    }
                else{
                    return FALSE;
                }
            }//if session key was ok
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

}
