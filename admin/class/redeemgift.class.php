<?php
   include 'config.php';
   include 'db.php';
   class Redeemgift extends Db{
      public function insert($table,$values,$check)
      {
            $sql="INSERT INTO ".$table." SET ";
            foreach ($values as $key => $value) {
              $arr[] =$key."='$value'";
            }
            $sql .= implode(',', $arr);
            $result = $this->execute_query($sql);
            return $result;
      }
       /*** for edi row process ***/
      public function update($table,$values,$check,$keyValue)
      {     
            $sql="UPDATE ".$table." SET ";
            foreach ($values as $key => $value) {
              $arr[] =$key."='$value'";
            }
            $sql .= implode(',', $arr);
            $sql.=" WHERE id=".$keyValue;
            $result = $this->execute_query($sql);
            return $result;
      }
   }
$obj = new Redeemgift();
  $slideshow=$obj->get_rows('redeem_gift');
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
               $width = 100; // new image width
               $height = 90; // new image height 
               $picname=str_replace(' ','-',$name).rand(100,1000);
               $values=array(
               'type' => $type,
               'name' => $name,
               'worth' => $worth,
               'points'  => $points,
               'file' => $picname.'.jpg',
               'status' => $status
               );
               $table='redeem_gift';
               $key='name';
               if($edit_category_id)
                  $result = $obj->update($table,$values,$key,$edit_category_id);
               else
                  $result = $obj->insert($table,$values,$key);  
               if($result) 
               {
                  if( ($extension=='jpeg') || ($extension=='jpg'))
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/images/redeemgift/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/images/redeemgift/".$picname.".".$extension;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->jpgtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                  }
                  else if( $extension=='png') 
                  {
                        $sourcefilePath=DOCUMENT_ROOT."/images/redeemgift/".$picname.".".$extension;
                        $destfilePath=DOCUMENT_ROOT."/images/redeemgift/".$picname;
                        $filename=$_FILES["file"]["tmp_name"];
                        $obj->pngtojpg($sourcefilePath,$destfilePath,$filename,$width,$height);
                        unlink(DOCUMENT_ROOT."/images/redeemgift/".$picname.".".$extension);
                  }
                  if($old_image)
                    unlink(DOCUMENT_ROOT."/images/redeemgift/".$old_image);
                 // @unlink($_SERVER['DOCUMENT_ROOT']."/omansupply/uploads/product-real/".$orgOldimage);
                  $success='Redeem Gift details saved';
               }
               else 
                  $error= 'Redeem Gift Name already exist';
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
            'type' => $type,
            'name' => $name,
            'worth' => $worth,
            'points'  => $points,
            'status' => $status
         );
         $table='redeem_gift';
         $key='name';
         if($edit_category_id)
            $result = $obj->update($table,$values,$key,$edit_category_id);
         else
            $result = $obj->insert($table,$values,$key);  
         if($result) 
         {
            $success='Redeem Gift details saved';
         }
         else 
            $error= 'Redeem Gift Name already exist';
      }
      
   }
   else
      $error= 'Redeem Gift Name must not be empty';
}?>