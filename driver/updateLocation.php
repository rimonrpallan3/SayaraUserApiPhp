<?php
require_once 'inc/DB_Functions.php';
$db = new DB_Functions();
 
if (isset($_POST['driver_id'])) 
{
    extract($_POST);
    if( ($driver_latitude!='')&&($driver_longitude!='') ){
        $res=$db->updateLocation($driver_id, $driver_latitude,$driver_longitude);
        if($res){
            $response["error"] = FALSE;
            $response["error_msg"] = "Driver Location Updated!";
            echo json_encode($response);
        }
        else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Sorry, Unable to update Location.";
            echo json_encode($response);
        }
    }
    
}
else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Sorry, Driver Id missing.";
    echo json_encode($response);
}
?>
