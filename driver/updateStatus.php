<?php
require_once 'inc/DB_Functions.php';
$db = new DB_Functions();
 
if (isset($_POST['driver_id'])) 
{
    extract($_POST);
    if($driver_online!=''){
        $res=$db->updateStatus($driver_id, $driver_online);
        if($res){
            $response["error"] = FALSE;
            $response["error_msg"] = "Driver Status Updated!";
            echo json_encode($response);
        }
        else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Sorry, Driver Id Invalid.";
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

