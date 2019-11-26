<?php 
	
	require_once '../includes/DbOperations.php';

	$response = array();

	if($_SERVER['REQUEST_METHOD']=='POST'){

		if( isset($_POST['name']) and 
			isset($_POST['std_id']) and
			isset($_POST['dept']) and
			isset($_POST['section'])
		){

			//operate the data

			$db = new DbOperations();

			$result = $db->addStudent($_POST['name'],$_POST['std_id'],$_POST['dept'],$_POST['section']);
			if($result == 1){
				$response['error'] = false;
				$response['message'] = "Student Add successfully";
			}elseif($result == 2){
				$response['error'] = true;
				$response['message'] = "Some error occurred please try again";
			}elseif($result == 0){
				$response['error'] = true;
				$response['message'] = "Student Already Exist, Choose Different Student Id";
			}

		}else{
			$response['error'] = true;
			$response['message'] = "Required fields are missing";
		}
	}else{
		$response['error'] = true;
		$response['message'] = "Invalid Request";
	}

	echo json_encode($response);
 ?>