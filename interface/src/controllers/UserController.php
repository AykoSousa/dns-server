<?php
namespace Controllers;

use Exception;
use Models\UserModel;

class UserController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new UserModel($db);
    }

    public function getUserByUsernameOrEmail($usernameOrEmail, $password): ?array
    {
        try {
            $user = $this->userModel->getUserByUsernameOrEmail($usernameOrEmail, $password);
            return $user;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function createUser($username, $email, $password): array
    {
        try {
            $user = $this->userModel->createUser($username, $email, $password);
            return $user;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}