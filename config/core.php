<?php
	// show error reporting
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	$home_url="http://localhost/api/";
	 
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	 
	// Количество записей на странице
	$records_per_page = 10;
	 
	// calculate for the query LIMIT clause
	//$from_record_num = ($records_per_page * $page) - $records_per_page;
	$from_record_num = $records_per_page * $page;
?>