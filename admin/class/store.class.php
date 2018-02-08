<?php
   include 'config.php';
   include 'db.php';
   class Store extends Db{
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
$obj = new Store();
if(@$_GET['category_id'])
  $stores=$obj->get_row_by_col('store','id',$_GET['category_id']);
else
  $stores=$obj->get_rows('store');
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
               $width = 130; // new image width
               $height = 80; // new image height
               $picname=str_replace(' ','-',$name).'-logo';
               $values=array(
               'name' => $name,
               'url'  => $url,
               'file' => $picname.'.jpg',
               'status' => $status
               );
               $table='store';
               $key='name';
               if($edit_category_id)
                  $result = $obj->update($table,$values,$key,$edit_category_id);
               else
                  $result = $obj->insert($table,$values,$key);  
               if($result) 
               {
                  if( ($extension=='jpeg') || ($extension=='jpg'))
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/images/store/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/images/store/".$picname.".".$extension;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->jpgtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                  }
                  else if( $extension=='png') 
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/images/store/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/images/store/".$picname;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->pngtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                        unlink(DOCUMENT_ROOT."/images/store/".$picname.".".$extension);
                  }
                  if($old_image)
                    unlink(DOCUMENT_ROOT."/images/store/".$old_image);
                 // @unlink($_SERVER['DOCUMENT_ROOT']."/omansupply/uploads/product-real/".$orgOldimage);
                  $success='Store details saved';
               }
               else 
                  $error= 'Store Name already exist';
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
            'url'  => $url,
            'status' => $status
         );
         $table='store';
         $key='name';
         if($edit_category_id)
            $result = $obj->update($table,$values,$key,$edit_category_id);
         else
            $result = $obj->insert($table,$values,$key);  
         if($result) 
         {
            $success='Store details saved';
         }
         else 
            $error= 'Store Name already exist';
      }
      
   }
   else
      $error= 'Store Name must not be empty';
}?>