<?php
class Db{
    public $db;
    public function __construct(){
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if(mysqli_connect_errno()) {
            echo "Error: Could not connect to database.";
            exit;
        }
    }
    /*** for get rows process ***/
      public function get_rows($table)
      { 
         $result = $this->execute_query("SELECT * FROM ".$table);
         $count_row = $result->num_rows;
         if ($count_row != 0){
            while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
            {
               $output[]=$row;
            }
            return $output;
         }
         else
            return false;  
      }
       /*** for get row by field process ***/
      public function get_row_by_col($table,$field,$key){ 
        $result = $this->execute_query("SELECT * FROM ".$table." WHERE ".$field."='".$key."'");
        $count_row = $result->num_rows;
        if ($count_row != 0){
          while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
          {
            $output[]=$row;
          }
          return $output;
        }
        else
          return false;
      }
       /*** for get row by field process ***/
      public function get_row_by_query($query){ 
        $result = $this->execute_query($query);
        $count_row = $result->num_rows;
        if ($count_row != 0){
          while($row=mysqli_fetch_array($result,MYSQL_ASSOC))
          {
            $output[]=$row;
          }
          return $output;
        }
        else
          return false;
      }
       public function delete_row_by_col($table,$field,$key){ 
        $result = $this->execute_query("DELETE FROM ".$table." WHERE ".$field."='".$key."'");
        if ($result)
          return $result;
        else
          return false;
      }
       /*** for get rows process ***/
      public function get_rows_by_count($table,$field,$key){ 
        $result = $this->execute_query("SELECT COUNT(*)  AS total FROM ".$table." WHERE ".$field."='".$key."'");
        $count_row = mysqli_fetch_row($result);
        if ($count_row[0] != 0)
          return $count_row[0];
        else
          return false;  
      }
    /*** for execute query process ***/
    public function execute_query($sql)
    {
        $result = mysqli_query($this->db,$sql) or die(mysqli_connect_errno()."Data cannot inserted");
        return $result;
    }
    public function pngtojpg($sourcefilePath,$destfilePath,$filename,$width,$height)
    {   
        move_uploaded_file($filename,$sourcefilePath);
        $image = imagecreatefrompng($sourcefilePath);
        $bg = imagecreatetruecolor($width, $height);
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        $image_info = getimagesize($sourcefilePath); 
        $width_orig  = $image_info[0]; // current width as found in image file
        $height_orig = $image_info[1]; // current height as found in image file
        imagecopyresampled($bg, $image, 0, 0, 0, 0, $width, $height,$width_orig, $height_orig);
        imagedestroy($image);
        $quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
        imagejpeg($bg, $destfilePath . ".jpg", $quality);
        imagedestroy($bg);
    }
    public function jpgtojpg($sourcefilePath,$destfilePath,$filename,$width,$height)
    {
        $reslt=move_uploaded_file($filename,$sourcefilePath);
        $orig_image = @imagecreatefromjpeg($sourcefilePath);
        $image_info = getimagesize($sourcefilePath); 
        $width_orig  = $image_info[0]; // current width as found in image file
        $height_orig = $image_info[1]; // current height as found in image file
        $destination_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($destination_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        $quality=100;
        imagejpeg($destination_image, $destfilePath,$quality);
    }
}