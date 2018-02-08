<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'inc/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['email']) && isset($_POST['password'])) {

    // receiving the post params
    $email = $_POST['email'];
    $password = $_POST['password'];

    // get the user by email and password
    $user = $db->getUserByEmailAndPassword($email, $password);

    if ($user != false) {
        // use is found
        $response["error"] = FALSE;
        $response["id"] = $user["id"];
        $response["name"] = $user["name"];
        $response["email"] = $user["email"];
        $response["phone"] = $user["phone"];
        $response["city"] = $user["city"];
        if($user["photo"]!='')
            $response["photo"] = "http://10.1.1.18/sayara/uploads/user/".$user["photo"];
        else
            $response["photo"] = "http://10.1.1.18/sayara/uploads/avatar-driver.png";
        $response["country"] = $user["country"];
        $response["created_at"] = $user["created_at"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>

