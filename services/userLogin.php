<?php 
	
	require_once '../includes/DbOperations.php';

	$response = array();

	if($_SERVER['REQUEST_METHOD']=='POST'){

		if( isset($_POST['username']) and 
			isset($_POST['password'])){

			//operate the data

			$db = new DbOperations();

			$result = $db->userLogin($_POST['username'],$_POST['password']);

			if($result){
				$response['error'] = false;
				$response['message'] = "User Login successfully";

				$user = $db->getUserByUsername($_POST['username']);

				$response['user'] = $user;
			}else{
				$response['error'] = true;
				$response['message'] = "Invalid username or password";
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