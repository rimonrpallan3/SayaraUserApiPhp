<?php
class Signout extends Db{
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
     
   }

$obj1 = new Signout();
if(@$_GET['userAction']=='logout')
{
    if(isset($_SESSION[ADMIN_SESSION]))
    {
      $result=$obj1->logout();
        header('Location: login.php');
    }
}
?>