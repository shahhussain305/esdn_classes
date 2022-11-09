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
                                'user'=>'ZXNkbl91c2Vy',
                                'key'=>'ZXNkbl9wYXNzd29yZCEy',
                                'host'=>'bG9jYWxob3N0',
                                'db'=>'ZXNkbl90ZXN0X2Ri'
                                );
    static $dba_user = array(
                                'user'=>'ZXNkbl91c2Vy',
                                'key'=>'ZXNkbl9wYXNzd29yZCEy',
                                'host'=>'bG9jYWxob3N0',
                                'db'=>'ZXNkbl90ZXN0X2Ri'
                                );

//change the following as per user previliges
//    static $view_user = array(
//                                'user'=>'esdn_user',
//                                'key'=>'esdn_password!2',
//                                'host'=>'localhost',
//                                'db'=>'esdn_test_db'
//                                );
//    static $dba_user = array(
//                                'user'=>'esdn_user',
//                                'key'=>'esdn_password!2',
//                                'host'=>'localhost',
//                                'db'=>'esdn_test_db'
//                                );
    
}