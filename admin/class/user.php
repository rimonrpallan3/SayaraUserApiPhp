<?php
  include 'config.php';
  include 'db.php';
  class User extends Db{
      /*** for login process ***/
      public function login($username, $password){
         $sql="SELECT * FROM admin WHERE username='$username' AND password='$password' AND status=1";
         //checking if the username is available in the table
         $result = $this->execute_query($sql);
         $user_data = mysqli_fetch_array($result);
         $count_row = $result->num_rows;
           if ($count_row == 1) {
               // this login var will use for the session thing
               $_SESSION['login'] = true;
               $_SESSION[ADMIN_SESSION] = $user_data['id'];
               return true;
           }
           else{
             return false;
         }
      }
      public function logout()
      {
        $ip= $_SERVER['REMOTE_ADDR'];
        $user=$_SESSION[ADMIN_SESSION];
        $date1=date('Y-m-d H:i:s') ;
        $sql="UPDATE admin SET last_login='$date1',ip='$ip' WHERE id='$user'";
        $result = $this->execute_query($sql);
        if($result){
          session_unset(ADMIN_SESSION);
          session_destroy();
          return true;
        }
        else
          return false;
        
      }
      /*** for add row process ***/
      public function insert_row($table,$values,$check){
         $sql="SELECT * FROM ".$table." WHERE ".$check."='".$values[$check]."'";
         //checking if the username or email is available in db
         $check =  $this->db->query($sql) ;
         $count_row = $check->num_rows;
         //if the username is not in db then insert to the table
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
      public function update_row($table,$values,$check,$keyValue){
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

      /*** for get rows process ***/
      public function get_rows($table){ 
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
       /*** for get rows process ***/
      public function get_rows_by_limit($table,$key){ 
        $result = $this->execute_query("SELECT * FROM ".$table." ".$key);
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
       /*** for get rows process ***/
      public function get_rows_count($table,$key){ 
        $result = $this->execute_query("SELECT * FROM ".$table." ".$key);
        $count_row = $result->num_rows;
        if ($count_row != 0){
          return $count_row;
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
      
      /*** for showing the username or fullname ***/
      public function get_fullname($uid){
         $sql3="SELECT fullname FROM users WHERE uid = $uid";
           $result = mysqli_query($this->db,$sql3);
           $user_data = mysqli_fetch_array($result);
           echo $user_data['fullname'];
      }

      /*** starting the session ***/
       public function get_session(){
           return $_SESSION['login'];
       }

       public function user_logout() {
           $_SESSION['login'] = FALSE;
           session_destroy();
       }

   }

