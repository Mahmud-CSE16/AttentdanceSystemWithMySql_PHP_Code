<?php 
	
	require_once '../includes/DbOperations.php';

	$response = array();

	//operate the data

	$db = new DbOperations();

	$students = $db->getAllStudents();

	$response["students"] = $students;

	echo json_encode($response);
 ?>