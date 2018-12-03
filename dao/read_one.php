<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Allow-Credentials: true");
	header('Content-Type: application/json');
	 
	include_once '../config/database.php';
	include_once '../objects/user.php';
	 
	// Подключение к бд
	$database = new Database();
	$db = $database->getConnection();
	 
	// Подготовка объекта "User"
	$user = new User($db);
	 
	// Установка свойства id пользователя для чтения
	$user->id = isset($_GET['id']) ? $_GET['id'] : die();
	
	$user->readOne();
	 
	if($user->name != null) {
		
		$user_arr = array(
			"id" =>  $user->id,
			"name" => $user->name,
			"surname" => $user->surname,
			"age" => $user->age,
			"address" => $user->address,
			"position" => $user->position,
			"salary" => $user->salary,
			"inn" => $user->inn
		);
	 
		http_response_code(200);
		echo json_encode($user_arr);
	} else {
	
		http_response_code(404);
		echo json_encode(array("message" => "Пользователя не существует."));
	}
?>