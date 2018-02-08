<?php
require_once("dbcontroller.php");
/* 
A domain Class to demonstrate RESTful web services
*/
Class Driver {
	private $Drivers = array();
	/*
		you should hookup the DAO here
	*/
	public function getAllDriver(){
		$query = "SELECT * FROM driver";
		$dbcontroller = new DBController();
		$this->Drivers = $dbcontroller->executeSelectQuery($query);
		return $this->Drivers;
	}
	public function getDriver($id){
		$query = "SELECT * FROM driver WHERE driver_id='$id'";
		$dbcontroller = new DBController();
		$this->Drivers = $dbcontroller->executeSelectQuery($query);
		return $this->Drivers;
	}	
}
?>