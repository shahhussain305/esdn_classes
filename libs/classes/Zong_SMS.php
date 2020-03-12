<?php
/* 
 * 
                This software is made by Shah Hussain, 
                Email: shahhussain305@gmail.com
                Cell No: 0313-9371236
                Computer Programmer 
                Peshawar High Court, Peshawar
 */
class Zong{
    
    var $mask = array('MASK_LABEL','110454');
    /**
     * 
     * @param String $messageText
     * @param int $toNumbersCsv
     * @param String $mask
     * @return Array()
     */
    public function sendSmsMessage($messageText,$toNumbersCsv){
        try{
            ini_set("soap.wsdl_cache_enabled", 0);
            $url        =  'http://cbs.zong.com.pk/ReachCWSv2/CorporateSmsV2.svc?wsdl';
            $client     = new SoapClient($url, array("trace" => 1, "exception" => 0));
            $configAry = array(	'LoginId'=>'923xxxxxxxx', //here type your account name
                                        'LoginPassword'=>'PASSWORD', //here type your password
                                        'Mask'=>$this->mask[0], //here set allowed mask against your account or you will get invalid mask
                                        'Message'=>$messageText,
                                        'UniCode'=>'0',
                                        'CampaignName'=>uniqid(), // Any random name or type uniqid() to generate random number, you can also specify campaign name here if want to send no to any existing campaign, numberCSV parameter will be ignored
                                        'CampaignDate'=>date('m/d/Y h:i:s a'),//'4/18/2017 11:00:00 am', data from where sms will start sending, if not sure type current date in m/d/y hh:mm:ss tt format.
                                        'ShortCodePrefered'=>'n',
                                        'NumberCsv'=>$toNumbersCsv
                                        );
                                        return $client->BulkSmsv2(array('objBulkSms' => $configAry));
                                    //echo"<br>REQUEST:\n" . htmlentities($client->__getLastRequest()) . "\n";
                                    }catch(Exception $exc){
                                        echo $exc->getMessage();
                             }
      }    
}
