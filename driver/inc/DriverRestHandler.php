<?php
require_once("RestApi.php");
require_once("Driver.php");
		
class DriverRestHandler extends RestApi {

	function getAllDrivers() {	

		$Driver = new Driver();
		$rawData = $Driver->getAllDriver();

		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('error' => 'No Drivers found!');		
		} else {
			$statusCode = 200;
		}

		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["output"] = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}
	public function getDriver($id){
		
		$Driver = new Driver();
		$rawData = $Driver->getDriver($id);

		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('error' => 'No Drivers found!');		
		} else {
			$statusCode = 200;
		}

		$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		
		$result["output"] = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}	
	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}
}
?>