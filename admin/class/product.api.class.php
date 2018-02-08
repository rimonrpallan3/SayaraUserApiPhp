<?php
   include 'config.php';
   include 'db.php';
   class Product extends Db{
      public function insert($table,$values,$code,$store)
      {
         $sql="SELECT id FROM ".$table." WHERE ".$code."='".$values[$code]."' AND ".$store."='".$values[$store]."'";
         $check =  mysqli_query($this->db,$sql);
         $row=mysqli_fetch_array($check,MYSQL_ASSOC);
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
         else { 
            $sql="UPDATE ".$table." SET ";
            foreach ($values as $key => $value) {
              $arr[] =$key."='$value'";
            }
            $sql .= implode(',', $arr);
            $sql.=" WHERE id=".$row['id'];
            $result = $this->execute_query($sql);
            return $result;
         }
      }
       public function update($table,$values,$keyValue){
            $sql="UPDATE ".$table." SET ";
            foreach ($values as $key => $value) {
              $arr[] =$key."='$value'";
            }
            $sql .= implode(',', $arr);
            $sql.=" WHERE id=".$keyValue;
            $result = $this->execute_query($sql);
            return $result;
      }
      public function delete($table,$keyValue){
            $sql="DELETE FROM ".$table." WHERE id=".$keyValue;
            $result = $this->execute_query($sql);
            return $result;
      }
      
   }
$obj = new Product();
$products=$obj->get_rows('product');
$stores=$obj->get_row_by_col('store','status','1');
if(isset($_POST['optsubmit']))
{
    if(!empty($_POST['checkarr'])) 
    {    
         $count=0;
         if($_POST['checkoption']=="enable")
         {
              foreach($_POST['checkarr'] as $check) 
              {
                  $values=array(
                   'status' => '1'
                  );
                  $table='product_api';
                  $result = $obj->update($table,$values,$check); 
                  if($result) 
                      $count++;
              }
         }
         if($_POST['checkoption']=="disable")
         {
              foreach($_POST['checkarr'] as $check) 
              {
                  $values=array(
                   'status' => '0'
                  );
                  $table='product_api';
                  $result = $obj->update($table,$values,$check); 
                  if($result) 
                      $count++;
              }
         }
         if($_POST['checkoption']=="delete")
         {
              foreach($_POST['checkarr'] as $check) 
              {
                  $table='product_api';
                  $result = $obj->delete($table,$check); 
                  if($result) 
                      $count++;
              }
         }
    }    
}

?>