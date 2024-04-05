<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class ApiController {
	private $db;
	private $userModel;

	public function __construct() {
		$config = require __DIR__ . '/../config/database.php';
		$this->db = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
		$this->userModel = new User($this->db);
	}

	public function index() {
		try {
			return $this->userModel->getAllUsers();
		} catch (Exception $e) {
			http_response_code(500); // Internal Server Error
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	public function show($id) {
		try {
			$user = $this->userModel->getUserById($id);
			if (!$user) {
				http_response_code(404); // Not Found
				echo json_encode(['error' => 'User not found']);
				return;
			}
			return $user;
		} catch (Exception $e) {
			http_response_code(500); // Internal Server Error
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	public function store($data) {
		try {
			// Validate input
			if (!isset($data['name']) || !isset($data['email'])) {
				http_response_code(400); // Bad Request
				echo json_encode(['error' => 'Name and email are required']);
				return;
			}

			// Create user
			$name = $data['name'];
			$email = $data['email'];
			return $this->userModel->createUser($name, $email);
		} catch (Exception $e) {
			http_response_code(500); // Internal Server Error
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	public function update($id, $data) {
		try {
			// Validate input
			if (!isset($data['name']) || !isset($data['email'])) {
				http_response_code(400); // Bad Request
				echo json_encode(['error' => 'Name and email are required']);
				return;
			}

			// Check if user exists
			$existingUser = $this->userModel->getUserById($id);
			if (!$existingUser) {
				http_response_code(404); // Not Found
				echo json_encode(['error' => 'User not found']);
				return;
			}

			// Update user
			$name = $data['name'];
			$email = $data['email'];
			return $this->userModel->updateUser($id, $name, $email);
		} catch (Exception $e) {
			http_response_code(500); // Internal Server Error
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	public function destroy($id) {
		try {
			// Check if user exists
			$existingUser = $this->userModel->getUserById($id);
			if (!$existingUser) {
				http_response_code(404); // Not Found
				echo json_encode(['error' => 'User not found']);
				return;
			}

			// Delete user
			return $this->userModel->deleteUser($id);
		} catch (Exception $e) {
			http_response_code(500); // Internal Server Error
			echo json_encode(['error' => $e->getMessage()]);
		}
	}
}
