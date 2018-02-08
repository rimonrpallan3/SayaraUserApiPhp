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
    public function storeUser($fullname, $email, $phone, $password, $city, $country) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted_password=$this->hashSSHA($salt, $password);
        $created_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("INSERT INTO user(name, email, phone, password, salt, city, country, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $fullname, $email, $phone, $encrypted_password, $salt, $city, $country, $created_at);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }
    /**
     * Update user profile
     * returns user details
     */
    public function updateUser($fullname, $user_id, $phone, $password, $city, $country) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted_password=$this->hashSSHA($salt, $password);
        $updated_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE user SET name=?, phone=?, password=?, salt=?, city=?, country=?, updated_at=? WHERE id=?");
        $stmt->bind_param("ssssssss", $fullname, $phone, $encrypted_password, $salt, $city, $country, $updated_at, $user_id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE id = ?");
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }
    /**
     * Update user name
     */
    public function updateName($user_id, $name) {
        $updated_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE user SET  name=?, updated_at=? WHERE id=?");
        $stmt->bind_param("sss", $name, $updated_at, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return true;
    }
    /**
     * Update user email
     */
    public function updateEmail($user_id, $email) {
        $updated_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE user SET  email=?, updated_at=? WHERE id=?");
        $stmt->bind_param("sss", $email, $updated_at, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return true;
    }
    /**
     * Update user password
     */
    public function updatePassword($user_id, $password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted_password=$this->hashSSHA($salt, $password);
        $updated_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE user SET  password=?, salt=?, updated_at=? WHERE id=?");
        $stmt->bind_param("ssss", $encrypted_password, $salt, $updated_at, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return true;
    }
    /**
     * Update user phone
     */
    public function updatePhone($user_id, $phone) {
        $updated_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE user SET  phone=?, updated_at=? WHERE id=?");
        $stmt->bind_param("sss", $phone, $updated_at, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return true;
    }
    /**
     * Update user city
     */
    public function updateCity($user_id, $city) {
        $updated_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE user SET  city=?, updated_at=? WHERE id=?");
        $stmt->bind_param("sss", $city, $updated_at, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return true;
    }
    /**
     * Update user photo
     * returns user details
     */
    public function updatePhoto($user_id, $user_photo) {
        $updated_at=date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE user SET  photo=?, updated_at=? WHERE id=?");
        $stmt->bind_param("sss", $user_photo, $updated_at, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return true;
    }
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }
    /**
     * Get user by email and password
     */
    public function getDriversList($latitude, $longitude) {

        $query = "SELECT driver_id,driver_first_name,driver_last_name,driver_phone,driver_email,driver_city,driver_country,driver_cpr,driver_photo,driver_car_type,driver_car_photo,driver_latitude,driver_longitude FROM driver WHERE driver_latitude = '$latitude' AND driver_longitude = '$longitude' AND driver_online = 1 ";
        $dbcontroller = new DB_Functions();
        $this->Drivers = $dbcontroller->executeSelectQuery($query);

        if($this->Drivers) {
            return $this->Drivers;
        } 
        else {
            return NULL;
        }
    }
     /**
     * Get all trips by user id
     */
    public function getAllTripByUser($user_id,$start,$count) {

        $query = "SELECT b.trip_id, b.trip_rating as trip_rating, c.name as car, DATE_FORMAT(b.pickup_time,'%d/%m/%Y %H:%i') as time,b.pay_type, b.amount, CONCAT('http://10.1.1.18/sayara/uploads/trips/',b.trip_image) as trip_image, CONCAT(d.driver_first_name,' ',d.driver_last_name) as driver_name,CONCAT('http://10.1.1.18/sayara/uploads/driver/',d.driver_photo) as driver_photo,d.driver_id,(d.driver_rating/d.users_rated) as driver_rating FROM booking b LEFT JOIN category c ON b.car_id=c.id LEFT JOIN driver d ON b.driver_id=d.driver_id WHERE b.user_id = '$user_id' ORDER BY trip_id DESC LIMIT $start,$count";
        $dbcontroller = new DB_Functions();
        $trips = $dbcontroller->executeSelectQuery($query);
        if ($trips)
            return $trips;
        else 
            return NULL;
    }
     /**
     * Get trip by user id and trip id
     */
    public function getTripByUserAndId($user_id, $trip_id) {

        $stmt = $this->conn->prepare("SELECT b.trip_id, b.trip_rating as trip_rating,c.name as car, b.pickup_time as time,b.pay_type, CONCAT(b.pay_unit,' ',b.amount) as amount, CONCAT('http://10.1.1.18/sayara/uploads/trips/',b.trip_image) as trip_image, CONCAT(d.driver_first_name,' ',d.driver_last_name) as driver_name,CONCAT('http://10.1.1.18/sayara/uploads/driver/',d.driver_photo) as driver_photo,d.driver_id FROM booking b LEFT JOIN category c ON b.car_id=c.id LEFT JOIN driver d ON b.driver_id=d.driver_id WHERE b.trip_id= ? AND b.user_id = ?");

        $stmt->bind_param("ss", $trip_id, $user_id);

        if ($stmt->execute()) {
            $trips = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            // check for password equality
            if ($trips){
                $drvrid=$trips['driver_id'];
                $stmt1 = $this->conn->prepare("SELECT AVG(trip_rating) as driver_rating FROM booking WHERE driver_id=?");
                $stmt1->bind_param("s", $drvrid);
                if ($stmt1->execute()) {
                    $ratings = $stmt1->get_result()->fetch_assoc();}
                $trips=array_merge($trips,$ratings);
                return $trips;
            }
                
            else 
                return NULL;
        } 
        else {
            return NULL;
        }
    }
     /**
     * Get driver profile by id
     */
    public function getDriverProfile($driver_id) {

        $query = "SELECT CONCAT(driver_first_name,' ',driver_last_name) as driver_name,CONCAT('http://10.1.1.18/sayara/uploads/driver/',driver_photo) as driver_photo,driver_id,(driver_rating/users_rated) as driver_rating,languages_known,DATE_FORMAT(created_at,'%M %Y') as member_from FROM driver d  WHERE driver_id = '$driver_id'";
        $dbcontroller = new DB_Functions();
        $trips = $dbcontroller->executeSelectQuery($query);
         if ($trips){
                $comments=$dbcontroller->executeSelectQuery("SELECT trip_comment FROM booking WHERE driver_id='$driver_id' ORDER BY trip_id DESC LIMIT 0,5");
                $arr['comments']=$comments;
                $trips=array_merge($trips,$arr);
                return $trips;
            }
                
            else 
                return NULL;
    }
     /**
     * Get driver found by id
     */
    public function getDriverFound($driver_id,$trip_id) {

        $query = "SELECT CONCAT(d.driver_first_name,' ',d.driver_last_name) as driver_name,CONCAT('http://10.1.1.18/sayara/uploads/driver/',d.driver_photo) as driver_photo,d.driver_id,(d.driver_rating/d.users_rated) as driver_rating, d.driver_car_photo,c.name as driver_car_name,b.booking_otp as booking_otp,b.trip_amount as trip_amount FROM driver d  LEFT JOIN category c ON d.driver_car_type=c.id LEFT JOIN booking b ON b.driver_id=d.driver_id WHERE d.driver_id = '$driver_id' AND b.trip_id='$trip_id'";
        $dbcontroller = new DB_Functions();
        $trips = $dbcontroller->executeSelectQuery($query);
         if ($trips){
                //$comments=$dbcontroller->executeSelectQuery("SELECT trip_id,trip_comment FROM booking WHERE driver_id='$driver_id' ORDER BY trip_id DESC");
                //$arr[]=$comments;
               // $trips=array_merge($trips,$arr);
                return $trips;
            }
                
            else 
                return NULL;
    }
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from user WHERE email = ? ");

        $stmt->bind_param("s", $email);

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
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function hashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
    
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
}

?>
