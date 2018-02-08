<?php
   include 'config.php';
   include 'db.php';
   class Category extends Db{
      public function insert($table,$values,$check)
      {
         $sql="SELECT * FROM ".$table." WHERE ".$check."=''";
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
$obj = new Category();
if(@$_GET['category_id'])
  $category=$obj->get_row_by_col('category','parent',$_GET['category_id']);
else
  $category=$obj->get_row_by_col('category','parent','0');
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
               $width = 180; // new image width
               $height = 180; // new image height
               $picname=str_replace(' ','-',$name).rand(100,1000);
               $values=array(
               'name' => $name,
               'parent'  => $parent,
               'file' => $picname.'.jpg',
               'status' => $status
               );
               $table='category';
               $key='name';
               if($edit_category_id)
                  $result = $obj->update($table,$values,$key,$edit_category_id);
               else
                  $result = $obj->insert($table,$values,$key);  
               if($result) 
               {
                  if( ($extension=='jpeg') || ($extension=='jpg'))
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/uploads/category/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/uploads/category/".$picname.".".$extension;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->jpgtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                  }
                  else if( $extension=='png') 
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/uploads/category/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/uploads/category/".$picname;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->pngtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                        unlink(DOCUMENT_ROOT."/uploads/category/".$picname.".".$extension);
                  }
                  if($old_image)
                    @unlink(DOCUMENT_ROOT."/uploads/category/".$old_image);
                 // @unlink($_SERVER['DOCUMENT_ROOT']."/omansupply/uploads/product-real/".$orgOldimage);
                  $success='Category details saved';
               }
               else 
                  $error= 'Category Name already exist';
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
            'parent'  => $parent,
            'status' => $status
         );
         $table='category';
         $key='name';
         if($edit_category_id)
            $result = $obj->update($table,$values,$key,$edit_category_id);
         else
            $result = $obj->insert($table,$values,$key);  
         if($result) 
         {
            $success='Category details saved';
         }
         else 
            $error= 'Category Name already exist';
      }
      
   }
   else
      $error= 'Category Name must not be empty';
}?>