<?php
/**
 * Description of DBU class=> Database Users Class collects existing users to connect to target database by 
 * providing user, password, host and database name
 * Benefits of DBU class=> 
 *      You can connect to database from each page with separate user which will have separate privileges, which will 
 *      minimize the threat to hack the database with DBA user. Values of each key has encrypted with base64_encode() function,
 *      and will need to decrypt the same in the DB.php class which has already been done. 
 *
 * @author shah
 */
class DBU {
    
    static $view_user = array(
                                'user'=>'dmlld19vbmx5',
                                'key'=>'VGVzdF9Vc2VyMSE=',
                                'host'=>'bG9jYWxob3N0',
                                'db'=>'cGhjX2Nhc2VmbG93'
                                );
    static $dba_user = array(
                                'user'=>'ZGJhX3VzZXI=',
                                'key'=>'RGJBX1VzRXIxIQ==',
                                'host'=>'bG9jYWxob3N0',
                                'db'=>'cGhjX2Nhc2VmbG93'
                                );
//    static $view_user = array(
//                                'user'=>'view_only',
//                                'key'=>'Test_User1!',
//                                'host'=>'localhost',
//                                'db'=>'phc_caseflow'
//                                );
//    static $dba_user = array(
//                                'user'=>'dba_user',
//                                'key'=>'DbA_UsEr1!',
//                                'host'=>'localhost',
//                                'db'=>'phc_caseflow'
//                                );
    
}