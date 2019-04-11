<?php

// Configurations list
// require_once 'settings.php' - instruct with construct.

$DB_CONNECT = array(
    'DB_HOST'     => 'localhost',
    'DB_NAME'     => 'gitres',
    'DB_USER'     => 'root',
    'DB_PASSWORD' => ''
);

SETTINGS::SET_DEFINE_CONNECT($DB_CONNECT);



$CNS_CONFIG = array(
    'CNS_DB_NAME' => 'gitres',
    'CNS_TB_NAME' => 'main'
);

SETTINGS::SET_DEFINE_CNS($CNS_CONFIG);



$SHOW_ERRORS = array(
    'E_TIMEOUT'   => '',
    'E_SPAM'      => '', 
    'E_WHITELIST' => ''    
);

SETTINGS::SET_DEFINE_ERRORS($SHOW_ERRORS);



$SHOW_INFO = array(
    'I_ONE'       => '',
    'I_TWO'       => '', 
    'I_THREE'     => ''    
);

SETTINGS::SET_DEFINE_INFO($SHOW_INFO);


