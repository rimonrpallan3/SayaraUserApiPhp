<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DBController.php';
        // connecting to database
        $db = new DBController();
        $this->conn = $db->connectDB();
    }

    // destructor
    function __destruct() {
        
    }  
    function executeSelectQuery($query) {
        $result = mysqli_query($this->conn,$query);
        while($row=mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if(!empty($resultset))
            return $resultset;
    }
    /**
     * Storing new user
     * returns user details
    */

    public function storeDriver($driver_first_name, $driver_last_name, $driver_phone, $driver_email, $driver_city, $driver_country, $cpr) {
        $created_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("INSERT INTO driver(driver_first_name, driver_last_name, driver_phone, driver_email, driver_city, driver_country, driver_cpr, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $driver_first_name, $driver_last_name, $driver_phone, $driver_email, $driver_city, $driver_country, $cpr, $created_at);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM driver WHERE driver_cpr = ? ");
            $stmt->bind_param("s", $cpr);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }

    public function storeDocument($driver_id, $document_type, $document_name) {
        $created_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("INSERT INTO driver_documents(driver_id, document_type, document_name) VALUES(?, ?, ?)");
        $stmt->bind_param("sss", $driver_id, $document_type, $document_name);
        $result = $stmt->execute();
        $stmt->close();
        return true;
    }
    /**
     * Update user name
    */
    public function updateStatus($driver_id, $status) {
        $updated_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE driver SET  driver_online=?, updated_at=? WHERE driver_id=?");
        $stmt->bind_param("sss", $status, $updated_at, $driver_id);
        $result = $stmt->execute();
        $stmt->close();
        return true;
    }
    public function updateLocation($driver_id, $driver_latitude,$driver_longitude) {
        $updated_at=date('Y-m-d H:i:s');
        $driver_location=$driver_latitude.','.$driver_longitude;
        $stmt = $this->conn->prepare("UPDATE driver SET  driver_location=?, updated_at=? WHERE driver_id=?");
        $stmt->bind_param("sss", $driver_location, $updated_at, $driver_id);
        $result = $stmt->execute();
        $stmt->close();
        $dat=date('Y-m-d');
        $location=date('H:i:s').'=>'.$driver_location;
        $stmt1 = $this->conn->prepare("SELECT driver_id from driver_locations WHERE driver_id = ? AND date=?");
        $stmt1->bind_param("ss",$driver_id,$dat);
        $stmt1->execute();
        $stmt1->store_result();
        if ($stmt1->num_rows > 0) {
            $stmt2 = $this->conn->prepare("UPDATE driver_locations SET  location=CONCAT(location,'^',?) WHERE driver_id=? AND date=?");
            $stmt2->bind_param("sss", $location, $driver_id,$dat);
            $result = $stmt2->execute();
            $stmt2->close();
        }
        else{
            $stmt = $this->conn->prepare("INSERT INTO driver_locations(driver_id, location, date) VALUES(?, ?, ?)");
            $stmt->bind_param("sss", $driver_id,$location,$dat);
            $result = $stmt->execute();
            $stmt->close();
        }
        return true;
    }
    /**
     * Get user by email and password
    */
    public function getDriveByUsernameAndPassword($username, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM driver WHERE username = ?");

        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying driver password
            $salt = $user['salt'];
            $encrypted_password = $user['password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // driver authentication details are correct
                $driver_id=$user['driver_id'];
                $stat="1";
                $stmt = $this->conn->prepare("UPDATE driver SET  driver_loggedin=?  WHERE driver_id=?");
                $stmt->bind_param("ss", $stat, $driver_id);
                $result = $stmt->execute();
                $stmt->close();
                return $user;
            }
        } else {
            return NULL;
        }
    }
    /**
     * Update user name
    */
    public function logOut($driver_id) {
        $stat="0";
        $stmt = $this->conn->prepare("UPDATE driver SET  driver_loggedin=?  WHERE driver_id=?");
        $stmt->bind_param("ss", $stat, $driver_id);
        $result = $stmt->execute();
        $stmt->close();
        return true;
    }
    /**
     * Check user is existed or not
    */
    public function isUserExisted($cpr) {
        $stmt = $this->conn->prepare("SELECT driver_cpr from driver WHERE driver_cpr = ? ");

        $stmt->bind_param("s", $cpr);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
    */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
    */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

}

?>
