<?php
   include 'config.php';
   include 'db.php';
   class Admin extends Db{
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
         $sql="SELECT * FROM ".$table." WHERE ".$check."='".$values[$check]."' AND id!=".$keyValue;
         //checking if the username or email is available in db
         $check =  $this->db->query($sql) ;
         $count_row = $check->num_rows;
         //if the username is not in db then insert to the table
         if ($count_row == 0){
            $sql="UPDATE ".$table." SET ";
            foreach ($values as $key => $value) {
              $arr[] =$key."='$value'";
            }
            $sql .= implode(',', $arr);
            $sql.=" WHERE id=".$keyValue;
            $result = $this->execute_query($sql);
            return $result;
         }
         else { return false;}
      }
   }
$obj = new Admin();
if(@$_GET['category_id'])
  $admin=$obj->get_row_by_col('admin','id',$_GET['category_id']);
else
  $admin=$obj->get_rows('admin');
//add store info
if (isset($_POST['submit'])) 
{
   extract($_REQUEST);
   $edit_category_id=$catid;
   if($name!='')
   {
      if(isset($_FILES['file']) && !empty($_FILES['file']['name'])) 
      {
         
         $allowedExts = array("jpeg","jpg","png");
         $temp = explode(".", $_FILES["file"]["name"]);
         $extension = end($temp);
         if ((($_FILES["file"]["type"] == "image/jpeg")|| ($_FILES["file"]["type"] == "image/jpg")|| ($_FILES["file"]["type"] == "image/png"))&& in_array($extension, $allowedExts))
         {
            if($_FILES["file"]["size"] < 1024000)
            {
               $width = 120; // new image width
               $height = 160; // new image height
               $picname=str_replace(' ','-',$name);
               $values=array(
               'name' => $name,
               'email'  => $email,
               'username'  => $username,
               'file' => $picname.'.jpg',
               'status' => $status
               );
               if($edit_category_id)
                  $arr1=array('updated_at' => date('Y-m-d H:i:s'));
               else
                  $arr1=array('created_at' => date('Y-m-d H:i:s'));
               if($password!='')
               {
                  $arr2=array('password' => md5($password));
                  $arr1=array_merge($arr1,$arr2);
               }
               $values=array_merge($values,$arr1);   
               $table='admin';
               $key='email';
               if($edit_category_id)
                  $result = $obj->update($table,$values,$key,$edit_category_id);
               else
                  $result = $obj->insert($table,$values,$key);  
               if($result) 
               {
                  if( ($extension=='jpeg') || ($extension=='jpg'))
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/uploads/admin/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/uploads/admin/".$picname.".".$extension;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->jpgtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                  }
                  else if( $extension=='png') 
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/uploads/admin/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/uploads/admin/".$picname;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->pngtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                        unlink(DOCUMENT_ROOT."/uploads/admin/".$picname.".".$extension);
                  }
                  if($old_image)
                    unlink(DOCUMENT_ROOT."/uploads/admin/".$old_image);
                 // @unlink($_SERVER['DOCUMENT_ROOT']."/omansupply/uploads/product-real/".$orgOldimage);
                  $success='Admin details saved';
               }
               else 
                  $error= 'Email already exist';
            }
            else
               $error="Upload image should be lassthan 1Mb";
         }
        else
            $error="Upload a valid image file <small>(jpg/png)</small>";      
      }
      else
      {
         $values=array(
            'name' => $name,
            'email'  => $email,
            'username'  => $username,
            'status' => $status
         );
         if($edit_category_id)
            $arr1=array('updated_at' => date('Y-m-d H:i:s'));
         else
            $arr1=array('created_at' => date('Y-m-d H:i:s'));
         if($password!='')
         {
            $arr2=array('password' => md5($password));
            $arr1=array_merge($arr1,$arr2);
         }
         $values=array_merge($values,$arr1);   
         $table='admin';
         $key='email';
         if($edit_category_id)
            $result = $obj->update($table,$values,$key,$edit_category_id);
         else
            $result = $obj->insert($table,$values,$key);  
         if($result) 
         {
            $success='Admin details saved';
         }
         else 
            $error= 'Email already exist';
      }
      
   }
   else
      $error= 'Admin Name must not be empty';
}?>