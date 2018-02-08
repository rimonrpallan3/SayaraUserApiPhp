<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'inc/DB_Functions.php';
$db = new DB_Functions();

// json response array
//$response = array("error" => FALSE);

//echo json_encode($_POST);
//exit;
$response=array();  
if(!isset($_POST['name'])&&(@$_POST['name']=='')){
    $response["name"]="User Name must be of 2 to 10 character";
}
if(!isset($_POST['phone'])&&(@$_POST['phone']=='')){
    $response["phone"]="Enter a valid mobile number";
}
if(!isset($_POST['email'])&&(@$_POST['email']=='')){
    $response["email"]="Enter a valid email address";
}
if(!isset($_POST['city'])&&(@$_POST['city']=='')){
    $response["city"]="Enter a valid city name";
}
if(!isset($_POST['country'])&&(@$_POST['country']=='')) {
    $response["country"]="Enter a valid country";
}
if(!isset($_POST['password'])&&(@$_POST['password']=='')) {
    $response["password"]="Enter a valid Password";
}

if(count($response)==0)
{
    // receiving the post params
    $fullname = $_POST['name'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $response["error"] = TRUE;
        $response["email"] = "Enter a valid email address " . $email;
        echo json_encode($response);
    }

    // check if user is already existed with the same email
    else if ($db->isUserExisted($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeUser($fullname, $email, $phone, $password, $city, $country);
        
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["id"] = $user["id"];
            $response["photo"] = "http://10.1.1.18/sayara/uploads/avatar-driver.png";
            $response["created_at"] = $user["created_at"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} 
else {
    $response["error"] = TRUE;
    //$response["error_msg"] = "Required parameter(s) missing!";
    //$response["errorList"]=$errorList;
    echo json_encode($response);
}
?>

