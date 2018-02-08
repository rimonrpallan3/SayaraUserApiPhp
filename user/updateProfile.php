<?php
require_once 'inc/DB_Functions.php';
$db = new DB_Functions();
 
if (isset($_POST['user_id'])) 
{
    extract($_POST);
    if(!empty($_FILES["user_photo"]['name'])) 
    {
        define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT'].'sayara');
        $allowedExts = array("jpeg","jpg","png");
        $target_dir = DOCUMENT_ROOT."/uploads/user/";
        $user_photo=basename($_FILES["user_photo"]["name"]);
        $target_file = $target_dir.$user_photo;
        if (move_uploaded_file($_FILES["user_photo"]["tmp_name"], $target_file)) {
            $res=$db->updatePhoto($user_id, $user_photo); 
            if($res){
                $response["error"] = FALSE;
                $response["error_msg"] = "User Profile Updated!";
                echo json_encode($response);
            }
        }
    }
    if(!empty($name)){
        $res=$db->updateName($user_id, $name);
        if($res){
            $response["error"] = FALSE;
            $response["error_msg"] = "User Profile Updated!";
            echo json_encode($response);
        }
    }
    if(!empty($email)){
        $res=$db->updateEmail($user_id, $email);
        if($res){
            $response["error"] = FALSE;
            $response["error_msg"] = "User Profile Updated!";
            echo json_encode($response);
        }
    }
    if(!empty($password)){
        $res=$db->updatePassword($user_id, $password);
        if($res){
            $response["error"] = FALSE;
            $response["error_msg"] = "User Profile Updated!";
            echo json_encode($response);
        }
    }
    if(!empty($phone)){
        $res=$db->updatePhone($user_id, $phone);
        if($res){
            $response["error"] = FALSE;
            $response["error_msg"] = "User Profile Updated!";
            echo json_encode($response);
        }
    }
    if(!empty($city)){
        $res=$db->updateCity($user_id, $city);
        if($res){
            $response["error"] = FALSE;
            $response["error_msg"] = "User Profile Updated!";
            echo json_encode($response);
        }
    }
}
else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Sorry, User Id missing.";
    echo json_encode($response);
}
?>

