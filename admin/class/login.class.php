<?php
  include 'config.php';
  include 'db.php';
  class Login extends Db{
      /*** for login process ***/
      public function signin($username, $password){
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
     
   }

$obj = new Login();
if(isset($_SESSION[ADMIN_SESSION]) && $page=='login')
{
    header('Location:'.BASE_URL.'/admin');
} 

if(@$_GET['userAction']=='logout')
{
    if(isset($_SESSION[ADMIN_SESSION]))
    {
      $result=$obj->logout();
        header('Location: login.php');
    }
}

//add user info
if (isset($_POST['login'])) {
    extract($_REQUEST);
    if($username!='')
    {
        if($password!='')
        {
            $login = $obj->signin($username, md5($password));
            if($login)
                header('Location: index.php');
            else 
                $error= 'Invalid username or password';
        }
        else
            $error= 'Password field must not be empty';
    }
    else
        $error= 'Username field must not be empty';
}

?>