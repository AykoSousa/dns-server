<?php
namespace Models;

use Exception;
use PDO;

class UserModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUserByUsernameOrEmail($usernameOrEmail, $password): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new Exception('User not found');
        }

        if (!password_verify($password, $result['password'])) {
            throw new Exception('Invalid password');
        }

        unset($result['password']);

        return $result;
    }

    public function createUser($username, $email, $password): array
    {
        $id = uniqid();
        $stmt = $this->db->prepare("INSERT INTO users (id, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id, $username, $email, password_hash($password, PASSWORD_BCRYPT)]);
        return ['id' => $id, 'username' => $username];
    }
}