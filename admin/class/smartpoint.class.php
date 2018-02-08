<?php
   include 'config.php';
   include 'db.php';
   class Smartpoint extends Db{
      public function insert($table,$values)
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
      public function update($table,$values,$keyValue)
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
$obj = new Smartpoint();
  $smartpoint=$obj->get_rows('points_earned');
   $redeemedpoints=$obj->get_rows('points_redeemed');
//add store info
if (isset($_POST['submit'])) 
{
   extract($_REQUEST);
   $edit_category_id=$catid;
   if($type!='')
   {
      if($points!='')
      {
         $values=array(
            'userid' => $user,
            'earn_type' => $type,
            'price' => $price,
            'points' => $points,
            'description' => $description,
            'status' => $status
         );
         if($status=='Expired'){
            $values1=array(
               'expire_date' => date('d-m-Y h:i:s'),
               'verify_date' => ''
            );
            $values=array_merge($values,$values1);
         }
         else if($status=='Verified'){
            $values2=array(
               'expire_date' => '',
               'verify_date' => date('d-m-Y h:i:s')
            );
            $values=array_merge($values,$values2);
         }
         else{
            $values3=array(
               'added_date' => date('d-m-Y h:i:s'),
               'verify_date' => '',
               'expire_date' => '',
            );
            $values=array_merge($values,$values3);
         }
         $table='points_earned';
         if($edit_category_id)
            $result = $obj->update($table,$values,$edit_category_id);
         else
            $result = $obj->insert($table,$values);  
         if($result) 
         {
            $success='Smartpoint details saved';
         }
         else 
            $error= 'Smartpoint Type already exist';
      }
      else
         $error= 'Points must not be empty';
      
   }
   else
      $error= 'Smartpoint Type must not be empty';
}
if (isset($_POST['submit-redeem'])) 
{
   extract($_REQUEST);
   $edit_category_id=$catid;
   if($type!='')
   {
      if($points!='')
      {
         $values=array(
            'userid' => $user,
            'giftid' => $type,
            'points' => $points,
            'status' => $status
         );
         
         $table='points_redeemed';
         if($edit_category_id)
            $result = $obj->update($table,$values,$edit_category_id);
         else
            $result = $obj->insert($table,$values);  
         if($result) 
         {
            $success='Redeemed Points details saved';
         }
         else 
            $error= 'Redeemed Points Type already exist';
      }
      else
         $error= 'Points must not be empty';
      
   }
   else
      $error= 'Redeem Type must not be empty';
}?>