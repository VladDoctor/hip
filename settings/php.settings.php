<?php

 class SETTINGS{
    
    public static function SET_DEFINE_CONNECT($_DATA){

       define('DB_HOST', $_DATA['DB_HOST'], true);
       define('DB_NAME', $_DATA['DB_NAME'], true);
       define('DB_USER', $_DATA['DB_USER'], true);
       define('DB_PASSWORD', $_DATA['DB_PASSWORD'], true);

    }

    public static function SET_DEFINE_CNS($_DATA){

        define('CNS_DB_NAME', $_DATA['CNS_DB_NAME'], true);
        define('CNS_TB_NAME', $_DATA['CNS_TB_NAME'], true);
 
    }
    
    public static function SET_DEFINE_ERRORS($_DATA){

        define('E_TIMEOUT', $_DATA['E_TIMEOUT'], true);
        define('E_SPAM', $_DATA['E_SPAM'], true); 
        define('E_WHITELIST', $_DATA['E_WHITELIST'], true);   

    }

    public static function SET_DEFINE_INFO($_DATA){
       
        define('I_ONE', $_DATA['I_ONE'], true);
        define('I_TWO', $_DATA['I_TWO'], true); 
        define('I_THREE', $_DATA['I_THREE'], true);   
  

    }
 }