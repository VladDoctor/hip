<?php
  
 session_start();

 require_once '../settings/php.settings.php';
 require_once '../conf.php';                      // own modules 
 require_once '../databases/connect.php';

 $mgrt_var = array(
    'all' => 'all',
    'databases' => 'databases',
    'tables' => 'tables'
 );

 $CONNECT_LI = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

 class CONSOLE{
   
    public function __construct($cmd, $array, $spare_connect){
                                                //split user_command and create second link for MySQL with OOP
        $this->CONNECT_LI = $spare_connect; 
        $command = preg_split('/ /', $cmd);
        $this->array = $array;
        $this->cmd_check($command);
   
    }

   public static function RET_MSG($message){
                                               //writing in logs - answers from console programm
        $file = fopen('../logs/php/work_with_jdata/log_answ.txt', 'w');
         fwrite($file, $message);
        fclose($file);

   }

   public function scn_migrate($key){ 

     if( $key == 'all' ):
        
        try{
            $this->CONNECT_LI->query("CREATE DATABASE IF NOT EXISTS gitres");
            $this->CONNECT_LI->query("CREATE TABLE IF NOT EXISTS main (
                id INT NOT NULL AUTO_INCREMENT, 
                title VARCHAR(255) NOT NULL, 
                date_r VARCHAR(255) NOT NULL,
                city VARCHAR(255) NOT NULL,
                category VARCHAR(255) NOT NULL,
                rating INT(255) NOT NULL, 
                url_id VARCHAR(255) NOT NULL, 
                PRIMARY KEY (id)
            )");
            $this->CONNECT_LI->query("CREATE TABLE IF NOT EXISTS reg_info (id INT NOT NULL AUTO_INCREMENT, title VARCHAR(255) NOT NULL, date_r VARCHAR(255) NOT NULL, ip_addr VARCHAR(255) NOT NULL, 
            PRIMARY KEY (id))");
            throw new Exception('['.date('G:i').'] CREATE DATABASES and TABLES - COMPLETE');
        }catch(Exception $e){
            CONSOLE::RET_MSG($e->getMessage());
        }

     elseif( $key == 'databases' ):
        
        try{
            $this->CONNECT_LI->query("CREATE DATABASE IF NOT EXISTS `gitres`");
            throw new Exception('['.date('G:i').'] CREATE DATABASES - COMPLETE');
        }catch(Exception $e){
            CONSOLE::RET_MSG($e->getMessage());
        }

     elseif( $key == 'tables' ):
        
        try{
            $this->CONNECT_LI->query("CREATE TABLE IF NOT EXISTS main (id INT NOT NULL AUTO_INCREMENT, title VARCHAR(255) NOT NULL, addr VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, 
            category VARCHAR(255) NOT NULL, rating INT(255) NOT NULL, url_id VARCHAR(255) NOT NULL, PRIMARY KEY (id))");
            $this->CONNECT_LI->query("CREATE TABLE IF NOT EXISTS reg_info (id INT NOT NULL AUTO_INCREMENT, title VARCHAR(255) NOT NULL, date_r VARCHAR(255) NOT NULL, ip_addr VARCHAR(255) NOT NULL, 
            PRIMARY KEY (id))");
            throw new Exception('['.date('G:i').'] CREATE TABLES - COMPLETE');
        }catch(Exception $e){
            CONSOLE::RET_MSG($e->getMessage());
        }
        //$sql = 'CREATE TABLE IF NOT EXISTS main (id INT NOT NULL AUTO_INCREMENT, title VARCHAR(255) NOT NULL, date_r VARCHAR(255) NOT NULL,
        //rating VARCHAR(255) NOT NULL, url_id VARCHAR(255) NOT NULL, PRIMARY KEY (id))';
        //$CONNECT->execute($data);

     else:                                      //else die... and...
        die();
     endif;
    } 

    public function scn_delete($key){
   
         if( $key == 'databases' ):
            
            try{
                $this->CONNECT_LI->query("DROP DATABASE gitres");
                throw new Exception('['.date('G:i').'] DROP DATABASES - COMPLETE');
            }catch(Exception $e){
                CONSOLE::RET_MSG($e->getMessage());
            }
   
         elseif( $key == 'tables' ):
            
            try{
                $this->CONNECT_LI->query("DROP TABLE main");
                throw new Exception('['.date('G:i').'] DROP TABLES - COMPLETE');
            }catch(Exception $e){
                CONSOLE::RET_MSG($e->getMessage());
            }

         else:
            die();
         endif;
    } 

   public static function log_cmd($str){

    $file = fopen('../logs/php/work_with_jdata/log_cns.txt', 'w');
     fwrite($file, $str);
    fclose($file);

   }

   public function cmd_check($cmd){
 
    if(in_array( 'gr--migrate', $cmd )):
        foreach( $this->array as $key => $value ):
            if(in_array( $value, $cmd )){
                CONSOLE::log_cmd($value);
                $this->scn_migrate($key);
            }else{
                CONSOLE::log_cmd($_SERVER['REMOTE_ADDR'].' ['.date('m.d.y').'] UNKNOWN VALUE FROM CMD - '.join(' ', $cmd));
            }
        endforeach;
    elseif(in_array( 'gr--delete', $cmd )):
        foreach( $this->array as $key => $value ):
            if(in_array( $value, $cmd )){
                CONSOLE::log_cmd($value);
                $this->scn_delete($key);
            }else{
                CONSOLE::log_cmd($_SERVER['REMOTE_ADDR'].' ['.date('m.d.y').'] UNKNOWN VALUE FROM CMD - '.join(' ', $cmd));
            }
        endforeach;
    else:
        CONSOLE::log_cmd($_SERVER['REMOTE_ADDR'].' ['.date('m.d.y').'] UNKNOWN CMD - '.join(' ', $cmd));
    endif;

   } 

 }

 try{
    
    $data = array(
         'cns_input' => htmlspecialchars(strip_tags(trim($_POST['cns_input'])))
    );

    $command = new CONSOLE($data['cns_input'], $mgrt_var, $CONNECT_LI);

    throw new Exception($data['cns_input']);
}catch(Exception $e){

    CONSOLE::log_cmd($_SERVER['REMOTE_ADDR'].' ['.date('m.d.y').'] '.$e->getMessage());

}
