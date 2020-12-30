<?php

namespace app\model;

use app\controller\Config;
use app\controller\Database;
use app\controller\Hash;
use app\controller\Session;

class User
{
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private int $phonenumber;
    private bool $isLoggedIn = false;
    private ?object $data = null;
    private ?Database $database = null;
    private $sessionName;

    public function __construct($user = null)
    {
        $this->database = Database::getInstance();
        $this->sessionName = Config::SESSION_NAME;

        if (!$user) {
            if (Session::exists($this->sessionName)) {
                $user = Session::get($this->sessionName);

                if ($this->find($user))
                {
                    $this->isLoggedIn = true;
                }
            } else {
                $this->find($user);
            }
        }
    }

    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    private function find($user = null): bool
    {
        if ($user)
        {
            $field = (is_numeric($user)) ? 'id' : 'email';
            $data = $this->database->get('users', array($field, '=', $user));

            if ($data->count())
            {
                $this->data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login(string $email = null, string $password = null, bool $remember = false)
    {
        var_dump($email, $password, $remember);
//        if (!$email && !$password && $this->exists())
//        {
//            Session::put($this->sessionName, $this->data()->id);
//        } else {
//            $user = $this->find($email);
//
//            if ($user)
//            {
//                if ($this->data()->password === Hash::make($password, $this->data()->salt))
//                {
//                    Session::put($this->sessionName, $this->data()->id);
//
//                    if ($remember) {
//                        $hash = Hash::unique();
//
//                    }
//                }
//            }
//        }
    }

    public function exists(): bool
    {
        return !empty($this->data);
    }

    public function data(): ?object
    {
        return $this->data;
    }

    public function isAuthenticated(): bool
    {
        return $this->isLoggedIn;
    }
}