<?php
require_once("inc/DriverRestHandler.php");

$view = "";
if(isset($_GET["view"]))
    $view = $_GET["view"];
/*
controls the RESTful services
URL mapping
*/
switch($view){

    case "all":
        // to handle REST Url /Driver/list/
        $DriverRestHandler = new DriverRestHandler();
        $DriverRestHandler->getAllDrivers();
        break;
        
    case "single":
        // to handle REST Url /Driver/show/<id>/
        $DriverRestHandler = new DriverRestHandler();
        $DriverRestHandler->getDriver($_GET["id"]);
        break;

    case "" :
        $DriverRestHandler = new DriverRestHandler();
        $DriverRestHandler->getAllDrivers();
        break;
}
?>