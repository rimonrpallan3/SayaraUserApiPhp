<?php
require_once 'inc/DB_Functions.php';
$db = new DB_Functions();
$response=array();  

if(!isset($_POST['driver_first_name'])&&(@$_POST['driver_first_name']=='')){
    $response["driver_first_name"]="First Name must be of 2 to 10 character";
}
if(!isset($_POST['driver_last_name'])&&(@$_POST['driver_last_name']=='')){
    $response["driver_last_name"]="Last Name must be of 2 to 10 character";
}
if(!isset($_POST['driver_phone'])&&(@$_POST['driver_phone']=='')){
    $response["driver_phone"]="Enter a valid mobile number";
}
if(!isset($_POST['driver_email'])&&(@$_POST['driver_email']=='')){
    $response["driver_email"]="Enter a valid email address";
}
if(!isset($_POST['driver_city'])&&(@$_POST['driver_city']=='')){
    $response["driver_city"]="Enter a valid city name";
}
if(!isset($_POST['driver_country'])&&(@$_POST['driver_country']=='')){
    $response["driver_country"]="Enter a valid country name";
}
if(!isset($_POST['driver_cpr'])&&(@$_POST['driver_cpr']=='')) {
    $response["driver_cpr"]="Enter a valid CPR";
}

if(count($response)==0)
{
    // receiving the post params
    $driver_first_name = $_POST['driver_first_name'];
    $driver_last_name = $_POST['driver_last_name'];
    $driver_phone = $_POST['driver_phone'];
    $driver_city = $_POST['driver_city'];
    $driver_country = $_POST['driver_country'];
    $driver_email = $_POST['driver_email'];
    $cpr = $_POST['driver_cpr'];
    if (filter_var($driver_email, FILTER_VALIDATE_EMAIL) === false) {
        $response["error"] = TRUE;
        $response["driver_email"] = "Enter a avalid email address " . $driver_email;
        echo json_encode($response);
    }

    // check if user is already existed with the same cpr
    else if ($db->isUserExisted($cpr)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $cpr;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeDriver($driver_first_name, $driver_last_name, $driver_phone, $driver_email, $driver_city, $driver_country, $cpr);
        
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["driver_id"] = $user["driver_id"];
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

