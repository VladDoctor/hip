<?php

 session_start();

 require_once '../settings/php.settings.php';
 require_once '../conf.php';                      // own modules 
 require_once '../databases/connect.php';

 interface DATA_INTERFACE{                       // interface for...

    public static function transform($data);
    public static function log_query($data);
    public static function regular_url($data);
    public static function check_media($data); 
    public function upload_media();

 }

 $LINK = new mysqli('127.0.0.1', 'root', '', 'gitres');

 class ADD implements DATA_INTERFACE{
    
  protected $INCLUSIONS = array();

  //private $br_json_users = file_get_contents('../logs/php/work_with_users.json');
  //private $br_json_jdata = file_get_contents('../logs/php/work_with_users.json');
  //private $br_json_media = file_get_contents('../logs/php/work_with_users.json');

   public function __construct($data, $data_media, $CONNECT){
      
      $this->data = ADD::transform($data);
      $this->data_media = ADD::check_media($data_media);
      $this->rating = 0;
      $this->date_r = date('m.d.y');
      $this->url_id = ADD::regular_url($data['name_inst']);
      $this->inserting($CONNECT);

   }

   public static function regular_url($data, $len = 8){
      
      $gen_url = '';
      for($i = 0; $i <= $len; $i++):
         $gen_url .= $data[rand(1, strlen($data))];
      endfor;
      return $gen_url;

   }

   public static function check_media($data_media){

      $result_media = array();

      foreach ($data_media as $key => $value):
         
         if( $key == 'photo_logo' ){
               
            if( $data_media[$key]['error'] != 0 && $data_media[$key]['size'] >= 5120 ):
               $error = $data_media[$key]['error'];
               $size = $data_media[$key]['size'];
               $INCLUSIONS .= "ERROR: $error || SIZE: $size (byte) .\n";
            else:
               $result_media[$key] = $value;
            endif;     

         }elseif( ($key == 'photo_one') || ($key == 'photo_two') || ($key == 'photo_three') ){

            if( ($data_media[$key]['error'] != 0 && $data_media[$key]['size']) >= 5120 ):
               $error = $data_media[$key]['error'];
               $size = $data_media[$key]['size'];
               $INCLUSIONS .= "ERROR: $error || SIZE: $size (byte) .\n";
            else:
               $result_media[$key] = $value;
            endif;

         }elseif( $key == 'photo_rew' ){

            if( $data_media[$key]['error'] != 0 && $data_media[$key]['size'] >= 5120 ):
               $error = $data_media[$key]['error'];
               $size = $data_media[$key]['size'];
               $INCLUSIONS .= "ERROR: $error || SIZE: $size (byte) .\n";
            else:
               $result_media[$key] = $value;
            endif;
               
         }else{

           if( empty($data_media[$key]) ):
             $INCLUSIONS .= "ERROR: $key IS EMPTY.\n";
           endif;

         }

      endforeach;

      if( empty($INCLUSIONS) ):
         return $result_media;
      endif;

   }

   public static function transform($data){

      foreach($data as $key => $value):
        $data[$key] = htmlspecialchars(strip_tags(trim($value)));
      endforeach; 

      return $data;

   }

   public function upload_media(){

      try{

         foreach ($this->data_media as $key => $value):

            if( $key == 'photo_logo' && isset($value) ):
               echo "5<br>";
               var_dump($this->data_media);
               move_uploaded_file($this->data_media['photo_logo']['tmp_name'], '../uploads/photo_logo/'.$this->data_media['photo_logo']['name']);
            elseif( $key == 'photo_rew' && isset($value) ):
               move_uploaded_file($this->data_media['photo_rew']['tmp_name'], '../uploads/photo_rew/'.$this->data_media['photo_rew']['name']);
            elseif( ($key == 'photo_one' || $key == 'photo_two' || $key == 'photo_three') && isset($value) ):
               move_uploaded_file($this->data_media[$key]['tmp_name'], '../uploads/photo_gallery/'.$this->data_media[$key]['name']);
            else:
               throw new Exception("ERROR: UNKNOWN FILE KEY - $key");
            endif;

         endforeach;

      }catch(Exception $e){

         $this->log_query($e->getMessage());

      }

   }

   private function inserting($CONNECT){
     
      foreach( $this->data as $key => $value ):
         if( $key == 'name_inst' ){

            $LINK = new mysqli('127.0.0.1', 'root', '', 'gitres');
            $result = $LINK->query("SELECT COUNT(*) FROM `main` WHERE `title` = '$value'");
            if( mysqli_num_rows($result) != 1 ):
               $INCLUSIONS .= 'ERROR: TITLE IS BUSY.\n';
            endif;

         }elseif( $key == 'addr_inst' ){

            $LINK = new mysqli('127.0.0.1', 'root', '', 'gitres');
            $result = $LINK->query("SELECT COUNT(*) FROM `main` WHERE `addr` = '$value'");
            if( mysqli_num_rows($result) != 1 ):
               $INCLUSIONS .= 'ERROR: ADDRESS IS BUSY.\n';
            endif;

         }else{

            if( empty($this->data[$key]) ):
               $INCLUSIONS .= "ERROR: $key IS EMPTY.\n";
            endif;

         }
      endforeach;

      try{

        $load_data_main = array(
           'name_inst'     => $this->data['name_inst'],
           'addr_inst'     => $this->data['addr_inst'],
           'city_inst'     => $this->data['city_inst'],
           'category_inst' => $this->data['category_inst'],
           'rating_inst'   => $this->rating,
           'url_id_inst'   => $this->url_id
        );

        $load_data_reg_info = array(
         'name_inst'     => $this->data['name_inst'],
         'date_r_inst'   => $this->date_r,
         'ip_addr_inst'  => $_SERVER['REMOTE_ADDR']
        );

        if( empty($INCLUSIONS) ):

          $sql_main = "INSERT INTO main (`title`, `addr`, `city`, `category`, `rating`, `url_id`) 
          VALUES (:name_inst, :addr_inst, :city_inst, :category_inst, :rating_inst, :url_id_inst)";
          $assertion_main = $CONNECT->prepare($sql_main);
          $ending_main = $assertion_main->execute($load_data_main);

          $sql_reg_info = "INSERT INTO reg_info (`title`, `date_r`, `ip_addr`) 
          VALUES (:name_inst, :date_r_inst, :ip_addr_inst)";
          $assertion_reg_info = $CONNECT->prepare($sql_reg_info);
          $ending_reg_info = $assertion_reg_info->execute($load_data_reg_info);

          try{

            $this->upload_media();
            throw new Exception($this->data_media['photo_logo']['name']);

          }catch(Exception $e){
      
            $this->log_query_media($this->data_media['photo_logo']['name']);

          }

        else:
          
          $this->log_query($INCLUSIONS);
          var_dump($INCLUSIONS);
          die();

        endif;

      }catch(Exception $e){

        ADD::log_query('Uuups... problems... '.$e->getMessage());

      }
   }

   public static function log_query($data_for_log){
      
      $JSON_data = array(
         'ip_addr' => $_SERVER['REMOTE_ADDR'],
         'time' => date('m.d.y'),
         'message' => $data_for_log
       );
      $log_data = json_encode($JSON_data, JSON_PRETTY_PRINT);

      $file = fopen('../logs/php/work_with_jdata.json', 'a');
       fwrite($file, $log_data, true);
      fclose($file);

   }

   public static function log_query_media($data_for_log){
     
      $JSON_data = array(
            'ip_addr' => $_SERVER['REMOTE_ADDR'],
            'time' => date('m.d.y'),
            'message' => $data_for_log
       );
      $log_data = json_encode($JSON_data, JSON_PRETTY_PRINT);

      $file_media = fopen('../logs/php/work_with_media.json', 'a');
       fwrite($file_media, $log_data, true);
      fclose($file_media);
  
   }

 }

 try{

    $data = array(
        'city_inst'     => $_POST['city_inst'],
        'category_inst' => $_POST['category_inst'],
        'name_inst'     => $_POST['name_inst'], 
        'addr_inst'     => $_POST['addr_inst'], 
        'feat_inst'     => $_POST['feat_inst'], 
        'cont_inst'     => $_POST['cont_inst'], 
        'cont_snd_inst' => $_POST['cont_snd_inst'],
        'wk_time_inst'  => $_POST['wk_time_inst'] 
    );

    $data_media = array(
       'photo_logo'     => $_FILES['photo_logo'],
       'photo_rew'      => $_FILES['photo_rew'],
       'photo_one'      => $_FILES['photo_one'],
       'photo_two'      => $_FILES['photo_two'],
       'photo_three'    => $_FILES['photo_three']    
    );
    
    $add_inst = new ADD($data, $data_media, $CONNECT);
    throw new Exception($data['city_inst'].' '.$data['name_inst'].' '.$data['addr_inst'].' '.$data['cont_inst'].' '.$data['cont_snd_inst']);
 }catch(Exception $e){
     
    ADD::log_query($e->getMessage());

 }