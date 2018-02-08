<?php
require_once 'inc/DB_Functions.php';
$db = new DB_Functions();
 
if (isset($_POST['driver_id'])) 
{
    extract($_POST);
    if(@$logout!=''){
        $res=$db->logOut($driver_id);
        $response["error"] = FALSE;
        $response["error_msg"] = "Driver Logged Out!";
        echo json_encode($response);
    }
    
}
else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Sorry, Driver Id missing.";
    echo json_encode($response);
}
?>