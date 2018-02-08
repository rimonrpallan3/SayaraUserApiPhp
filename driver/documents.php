<?php
require_once 'inc/DB_Functions.php';
$db = new DB_Functions();
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT'].'sayara');
$allowedExts = array("jpeg","jpg","png");
$target_dir = DOCUMENT_ROOT."/uploads/documents/";
if (isset($_POST['driver_id'])) {
	if((isset($_POST['document_type'])) && ($_POST['document_type']!=''))
    {
        if(!empty($_FILES["document_name"]['name'])) 
	   {
            $driver_id=$_POST['driver_id']; 
            $document_type=$_POST['document_type']; 
            $document_name=basename($_FILES["document_name"]["name"]);
		    $target_file = $target_dir.$document_name;
		    if (move_uploaded_file($_FILES["document_name"]["tmp_name"], $target_file)) {
			    $user = $db->storeDocument($driver_id, $document_type, $document_name);
                $response["error"] = FALSE;
        	    $response["success_msg"] = "Document Uploaded!";
        	    echo json_encode($response);
    	    } else {
        	    $response["error"] = TRUE;
        	    $response["error_msg"] = "Sorry, there was an error uploading your document.";
    		    echo json_encode($response);
    	    }
	   }
       else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Sorry, Document missing.";
            echo json_encode($response);
        }
    }
    else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Sorry, Document Type missing.";
        echo json_encode($response);
    }
}
else{
	$response["error"] = TRUE;
    $response["error_msg"] = "Sorry, Driver Id missing.";
    echo json_encode($response);
}?>