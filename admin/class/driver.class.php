<?php
   include 'config.php';
   include 'db.php';
   class driver extends Db{
      public function insert($table,$values,$check)
      {
         $sql="SELECT * FROM ".$table." WHERE ".$check."='".$values[$check]."'";
         $check =  $this->execute_query($sql);
         $count_row = $check->num_rows;
         if ($count_row == 0){
            $sql="INSERT INTO ".$table." SET ";
            foreach ($values as $key => $value) {
              $arr[] =$key."='$value'";
            }
            $sql .= implode(',', $arr);
            $result = $this->execute_query($sql);
            return $result;
         }
         else { return false;}
      }
       /*** for edi row process ***/
      public function update($table,$values,$check,$keyValue){
         $sql="SELECT * FROM ".$table." WHERE ".$check."='".$values[$check]."' AND driver_id!=".$keyValue;
         //checking if the drivername or email is available in db
         $check =  $this->db->query($sql) ;
         $count_row = $check->num_rows;
         //if the drivername is not in db then insert to the table
         if ($count_row == 0){
            $sql="UPDATE ".$table." SET ";
            foreach ($values as $key => $value) {
              $arr[] =$key."='$value'";
            }
            $sql .= implode(',', $arr);
            $sql.=" WHERE driver_id=".$keyValue;
            $result = $this->execute_query($sql);
            return $result;
         }
         else { return false;}
      }
      public function hashSSHA($salt, $password) {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
      }

   }
$obj = new driver();
if(@$_GET['category_id'])
  $driver=$obj->get_row_by_col('driver','id',$_GET['category_id']);
else
  $driver=$obj->get_rows('driver');

$category=$obj->get_row_by_col('category','parent!','0');
//add store info
if (isset($_POST['submitBasicInfo'])) 
{
   extract($_REQUEST);
   $edit_category_id=$catid;
   if($first_name!='')
   {
      $values=array(
         'driver_first_name' => $first_name,
         'driver_last_name' => $last_name,
         'driver_email'  => $email,
         'driver_phone'  => $phone,
         'driver_city'  => $city,
         'driver_country'  => $country,
         'driver_cpr'  => $cpr,               
         'username'  => $username,
         'driver_status' => $status,
         'driver_online_change' => $online_status_change
      );
      if($edit_category_id)
         $arr1=array('updated_at' => date('Y-m-d H:i:s'));
      else
         $arr1=array('created_at' => date('Y-m-d H:i:s'));
      if($password!='')
      {
         $salt = sha1(rand());
         $salt = substr($salt, 0, 10);
         $encrypted_password=$obj->hashSSHA($salt, $password);
         $arr2=array(
            'password' => $encrypted_password,
            'salt'  => $salt
         );
         $arr1=array_merge($arr1,$arr2);
      }
      $values=array_merge($values,$arr1);   
      $table='driver';
      $key='driver_cpr';
      if($edit_category_id)
         $result = $obj->update($table,$values,$key,$edit_category_id);
      else
         $result = $obj->insert($table,$values,$key);  
      if($result) 
         $success='Driver details saved';
      else 
         $error= 'CPR already exist';
      if(isset($_FILES['file']) && !empty($_FILES['file']['name'])) 
      { 
         $allowedExts = array("jpeg","jpg","png");
         $temp = explode(".", $_FILES["file"]["name"]);
         $extension = end($temp);
         if ((($_FILES["file"]["type"] == "image/jpeg")|| ($_FILES["file"]["type"] == "image/jpg")|| ($_FILES["file"]["type"] == "image/png"))&& in_array($extension, $allowedExts))
         {
            if($_FILES["file"]["size"] < 1024000)
            {
               $width = 215; // new image width
               $height = 215; // new image height
               $picname=str_replace(' ','-',$cpr);
               $values=array(
               'driver_cpr'  => $cpr,               
               'driver_photo' => $picname.'.jpg'
               );
                
               $table='driver';
               $key='driver_cpr';
               if($edit_category_id)
                  $result = $obj->update($table,$values,$key,$edit_category_id);
               else
                  $result = $obj->insert($table,$values,$key);  
               if($result) 
               {
                  if($old_image)
                     unlink(DOCUMENT_ROOT."/uploads/driver/".$old_image);
                  if( ($extension=='jpeg') || ($extension=='jpg'))
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/uploads/driver/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/uploads/driver/".$picname.".".$extension;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->jpgtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                  }
                  else if( $extension=='png') 
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/uploads/driver/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/uploads/driver/".$picname;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->pngtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                        unlink(DOCUMENT_ROOT."/uploads/driver/".$picname.".".$extension);
                  }
                  $success='Driver details saved';
               }
               else 
                  $error= 'CPR already exist';
            }
            else
               $error="Upload image should be lassthan 1Mb";
         }
         else
            $error="Upload a valid image file <small>(jpg/png)</small>";      
      }
   
   }
   else
      $error= 'Driver Name must not be empty';
}


if (isset($_POST['submitCabInfo'])) 
{
   extract($_REQUEST);
   $edit_category_id=$catid;
   if($car_type!='')
   {
      if(!@$cpr)
         $cpr=rand(1000,10000);
      $values=array(
         'driver_cpr'  => $cpr,  
         'driver_car_type' => $car_type
      );
      if($edit_category_id)
         $arr1=array('updated_at' => date('Y-m-d H:i:s'));
      else
         $arr1=array('created_at' => date('Y-m-d H:i:s'));
      
      $values=array_merge($values,$arr1);   
      $table='driver';
      $key='driver_cpr';
      if($edit_category_id)
         $result = $obj->update($table,$values,$key,$edit_category_id);
      else
         $result = $obj->insert($table,$values,$key);  
      if($result) 
         $success='Driver details saved';
      
      if(isset($_FILES['car_photo']) && !empty($_FILES['car_photo']['name'])) 
      { 
         $allowedExts = array("jpeg","jpg","png");
         $temp = explode(".", $_FILES["car_photo"]["name"]);
         $extension = end($temp);
         if ((($_FILES["car_photo"]["type"] == "image/jpeg")|| ($_FILES["car_photo"]["type"] == "image/jpg")|| ($_FILES["car_photo"]["type"] == "image/png"))&& in_array($extension, $allowedExts))
         {
            if($_FILES["car_photo"]["size"] < 1024000)
            {
               $width = 285; // new image width
               $height = 215; // new image height
               $picname='car-'.str_replace(' ','-',$cpr);
               $values=array(
               'driver_cpr'  => $cpr,               
               'driver_car_photo' => $picname.'.jpg'
               );
                
               $table='driver';
               $key='driver_cpr';
               if($edit_category_id)
                  $result = $obj->update($table,$values,$key,$edit_category_id);
               else
                  $result = $obj->insert($table,$values,$key);  
               if($result) 
               {
                  if($old_car_image)
                     unlink(DOCUMENT_ROOT."/uploads/cars/".$old_car_image);
                  if( ($extension=='jpeg') || ($extension=='jpg'))
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/uploads/cars/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/uploads/cars/".$picname.".".$extension;
                        $filename=$_FILES["car_photo"]["tmp_name"];
                        $obj->jpgtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                  }
                  else if( $extension=='png') 
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/uploads/cars/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/uploads/cars/".$picname;
                        $filename=$_FILES["car_photo"]["tmp_name"];
                        $obj->pngtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                        unlink(DOCUMENT_ROOT."/uploads/cars/".$picname.".".$extension);
                  }
                  
                  $success='Driver details saved';
               }
               else 
                  $error= 'CPR already exist';
            }
            else
               $error="Upload image should be lassthan 1Mb";
         }
         else
            $error="Upload a valid image file <small>(jpg/png)</small>";      
      }   
   }
   else
      $error= 'Driver Cab Type must not be empty';
}

if (isset($_POST['submitDocumentInfo'])) 
{  
  if (isset($_POST['driver_id'])) 
  { 
    if((isset($_POST['document_type'])) && ($_POST['document_type']!=''))
    {
      if(!empty($_FILES["document_name"]['name'])) 
      {
        extract($_REQUEST);
        $target_dir = DOCUMENT_ROOT."/uploads/documents/";
        $document_name=$document_type.$driver_id;
        $temp = explode(".", $_FILES["document_name"]["name"]);
        $extension = end($temp);
        $target_file = $target_dir.$document_name.'.'.$extension;
        $values=array(
         'driver_id'  => $driver_id,  
         'document_type' => $document_type,
         'document_name' => $document_name.'.'.$extension
        );
        $table='driver_documents';
        $key='document_name';
        $result = $obj->insert($table,$values,$key);
        if($result) 
        { 
          if(move_uploaded_file($_FILES["document_name"]["tmp_name"], $target_file)) 
            $success='Driver details saved';
          else
            $error= 'Unable to upload file to '.$target_file;  
        } 
        else
          $error= 'Document already exists'; 
      }
      else
        $error= 'Document missing';
    }
    else
      $error= 'Document type missing';
  }
  else
    $error= 'Driver Id missing';
}?>