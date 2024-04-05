<?php

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = $id";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($result);
    }

    public function createUser($name, $email) {
        $createdAt = date('Y-m-d H:i:s');
        $query = "INSERT INTO users (name, email, created_at) VALUES ('$name', '$email', '$createdAt')";
        mysqli_query($this->db, $query);
        return mysqli_insert_id($this->db);
    }

    public function updateUser($id, $name, $email) {
        $editedAt = date('Y-m-d H:i:s');
        $query = "UPDATE users SET name='$name', email='$email', edited_at='$editedAt' WHERE id=$id";
        mysqli_query($this->db, $query);
        return mysqli_affected_rows($this->db);
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id=$id";
        mysqli_query($this->db, $query);
        return mysqli_affected_rows($this->db);
    }
}
