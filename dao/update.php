<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: PUT");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	include_once '../config/database.php';
	include_once '../objects/user.php';
	 
	// Получение доступа к бд
	$database = new Database();
	$db = $database->getConnection();
	
	$user = new User($db);
	
	$data = json_decode(file_get_contents("php://input"));
	
	$user->id = $data->id;
	
	$user->name = $data->name;
	$user->surname = $data->surname;
	$user->age = $data->age;
	$user->address = $data->address;
	$user->position = $data->position;
	$user->salary = $data->salary;
	$user->inn = $data->inn;
	
	if ($user->update($data)) {
		
		http_response_code(200);
		echo json_encode(array("message" => "Пользователь обновлен."));
		
	} else {
		
		http_response_code(503);
		echo json_encode(array("message" => "Не удалось обновить пользователя."));
		
	}
?>