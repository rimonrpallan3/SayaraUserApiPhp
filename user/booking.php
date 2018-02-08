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
    if (isset($_POST['current_loc']) && isset($_POST['pickup_loc']) && isset($_POST['drop_loc'])) {
        // receiving the post params
        $current_loc = explode(',',$_POST['current_loc']);
        $pickup_loc = $_POST['pickup_loc'];
        $current_loc_lat=$current_loc[0];
        $current_loc_lng=$current_loc[1];
        // get the driver by location
        $drivers = $db->getDriversList($current_loc_lat, $current_loc_lng);
        if ($drivers != false) {
            // drivers is found
            echo json_encode($drivers);
        } else {
            // driver is not found with the credentials
            $response["error"] = TRUE;
            $response["error_msg"] = "Drivers not found on this location!";
            echo json_encode($response);
        }
    }
    else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Sorry, location missing.";
        echo json_encode($response);
    }
}
else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Sorry, User Id missing.";
    echo json_encode($response);
}
    
?>