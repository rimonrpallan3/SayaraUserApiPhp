<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'inc/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['user_id'])) 
{
    if (isset($_POST['driver_id'])) {
       $driver_id=$_POST['driver_id'];
       $trip_id=$_POST['trip_id'];
        $drivers = $db->getDriverFound($driver_id,$trip_id);
        if ($drivers != false) {
            // drivers is found
            echo json_encode($drivers);
        } else {
            // driver is not found with the credentials
            $response["error"] = TRUE;
            $response["error_msg"] = "Drivers not found on this id!";
            echo json_encode($response);
        }
    }
    else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Sorry, driver Id missing.";
        echo json_encode($response);
    }
}
else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Sorry, User Id missing.";
    echo json_encode($response);
}
    
?>