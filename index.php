<?php

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	http_response_code(200);
	exit;
}

require_once 'app/controllers/ApiController.php';

use ApiController;

// Routing logic
$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

$apiController = new ApiController();

switch ($method) {
case 'GET':
	if ($request == '/users') {
		echo json_encode($apiController->index());
	} else {
		preg_match('/\/users\/(\d+)/', $request, $matches);
		if ($matches) {
			echo json_encode($apiController->show($matches[1]));
		}
	}
	break;

case 'POST':
	if ($request == '/users') {
		// Assuming JSON payload for simplicity
		$data = json_decode(file_get_contents('php://input'), true);
		echo $apiController->store($data);
	}
	break;

case 'PUT':
	preg_match('/\/users\/(\d+)/', $request, $matches);
	if ($matches) {
		// Assuming JSON payload for simplicity
		$data = json_decode(file_get_contents('php://input'), true);
		echo $apiController->update($matches[1], $data);
	}
	break;

case 'DELETE':
	preg_match('/\/users\/(\d+)/', $request, $matches);
	if ($matches) {
		echo $apiController->destroy($matches[1]);
	}
	break;

default:
	http_response_code(405); // Method Not Allowed
	break;
}