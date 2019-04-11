<?php

try{
    
    //define(DB_OPTIONS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION], true);
    $CONNECT = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME .'', ''. DB_USER .'', ''. DB_PASSWORD .'');
    throw new Exception('- Connection is true');

}catch(Exception $e){

   //var_dump($e->getMessage());

}