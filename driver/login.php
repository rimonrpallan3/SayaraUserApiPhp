<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'inc/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['username']) && isset($_POST['password'])) {

    // receiving the post params
    $username = $_POST['username'];
    $password = $_POST['password'];

    // get the driver by email and password
    $user = $db->getDriveByUsernameAndPassword($username, $password);

    if ($user != false) {
        // driver is found
        if($user["driver_loggedin"]==0)
        {
            $response["error"] = FALSE;
            $response["driver_id"] = $user["driver_id"];
            $response["driver_first_name"] = $user["driver_first_name"];
            $response["driver_last_name"] = $user["driver_last_name"];
            $response["driver_email"] = $user["driver_email"];
            $response["driver_phone"] = $user["driver_phone"];
            $response["driver_cpr"] = $user["driver_cpr"];
            $response["driver_city"] = $user["driver_city"];
            $response["driver_country"] = $user["driver_country"];
            $response["driver_online"] = $user["driver_online"];
            $response["driver_online_change"] = $user["driver_online_change"];
            echo json_encode($response);
        }
        else {
            // driver already logged in
            $response["error"] = TRUE;
            $response["error_msg"] = "Driver Already Logged In. Please logOut!";
            echo json_encode($response);
        }
    } else {
        // driver is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters username or password is missing!";
    echo json_encode($response);
}
?>

