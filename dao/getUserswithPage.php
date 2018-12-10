<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	
	include_once '../config/core.php';
	include_once '../shared/utilities.php';
	include_once '../config/database.php';
	include_once '../objects/user.php';
	
	$utilities = new Utilities();
	
	$database = new Database();
	$db = $database->getConnection();
	$user = new User($db);
	 
	$stmt = $user->readPaging($from_record_num, $records_per_page);
	$num = $stmt->rowCount();
	
	if($num > 0) {
	
		$users_arr = array();
		$users_arr["records"] = array();
		$users_arr["paging"] = array();
	 
		// retrieve our table contents
		// fetch() is faster than fetchAll()
		// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			extract($row);
	 
			$user_item = array(
				"id" => $id,
				"name" => $name,
				"surname" => $surname,
				"age" => $age,
				"address" => $address,
				"position" => $position,
				"salary" => $salary,
				"inn" => $inn
			);
			array_push($users_arr["records"], $user_item);
		}
	
		$total_rows = $user -> count();
		$page_url = "{$home_url}dao/getUserwithPage.php?";
		$paging = $utilities -> getPaging($page, $total_rows, $records_per_page, $page_url);
		$users_arr["paging"] = $paging;
	 
		http_response_code(200);
		echo json_encode($users_arr);
		
	} else {
		http_response_code(404);
		echo json_encode(
			array("message" => "No users found.")
		);
	}
?>