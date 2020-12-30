<?php

namespace app\model;

use app\controller\Database;

class User
{
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private int $phonenumber;
    private bool $isLoggedIn = false;
    private ?Database $database = null;

    public function __construct(string $firstname, string $lastname, int $phonenumber, string $email, string $password)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->phonenumber = $phonenumber;
        $this->email = $email;
        $this->password = $password;
        $this->database = Database::getInstance();
    }

    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function isAuthenticated(): bool
    {
        return $this->isLoggedIn;
    }
}