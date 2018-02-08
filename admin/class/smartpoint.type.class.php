<?php
   include 'config.php';
   include 'db.php';
   class Set_smartpoint extends Db{
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
$obj = new Set_smartpoint();
  $smartpoint=$obj->get_rows('earn_type');
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
            'type' => $type,
            'points' => $points,
            'per_value' => $per_value,
            'status' => $status
         );
         $table='earn_type';
         $key='type';
         if($edit_category_id)
            $result = $obj->update($table,$values,$key,$edit_category_id);
         else
            $result = $obj->insert($table,$values,$key);  
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
}?>