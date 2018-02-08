<?php
require_once("DB_Functions.php");
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
		$dbcontroller = new DB_Functions();
		$this->Drivers = $dbcontroller->executeSelectQuery($query);
		return $this->Drivers;
	}
	public function getDriver($id){
		$query = "SELECT * FROM driver WHERE driver_id='$id'";
		$dbcontroller = new DB_Functions();
		$this->Drivers = $dbcontroller->executeSelectQuery($query);
		return $this->Drivers;
	}	
}
?>