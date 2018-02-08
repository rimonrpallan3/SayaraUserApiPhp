<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'inc/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);
 
if(isset($_POST['user_id'])) 
{
    $user_id=$_POST['user_id'];
    if (isset($_REQUEST['trip_id'])) {
        // receiving the post params
        $trip_id = $_REQUEST['trip_id'];
        // get the trip by id
        $trip = $db->getTripByUserAndId($user_id, $trip_id);
        if ($trip != false) {
            // trip is found
            echo json_encode($trip);
        } else {
            // trip is not found with the credentials
            $response["error"] = TRUE;
            $response["error_msg"] = "Trip not found for this id!";
            echo json_encode($response);
        }
    }
    else{
        $limit=2;$start=0;
        if (isset($_REQUEST['page']) && ($_REQUEST['page']>1)) 
            $start=$start+($limit*($_REQUEST['page']-1));
        
        // get the trip by id
        $trip = $db->getAllTripByUser($user_id,$start,$limit);
        if ($trip != false) {
            // trip is found
            echo json_encode($trip);
        } else {
            // trip is not found with the credentials
            $response["error"] = TRUE;
            $response["error_msg"] = "Trip not found for this user!";
            $arr[]=$response;
            echo json_encode($arr);
        }
    }
}
else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Sorry, User Id missing.";
    echo json_encode($response);
}
    
?>