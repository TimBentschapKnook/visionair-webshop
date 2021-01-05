<?php

namespace app\model;

use app\controller\Config;
use app\controller\Database;
use app\controller\Hash;
use app\controller\Redirect;
use app\controller\Session;
use app\controller\Cookie;

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
    private $cookieName;

    public function __construct($user = null)
    {
        $this->database = Database::getInstance();
        $this->sessionName = Config::SESSION_NAME;
        $this->cookieName = Config::COOKIE_NAME;

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
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->database->get('users', array($field, '=', $user));
            if ($data->count())
            {
                $this->data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login(string $email = null, string $password = null, bool $remember = false): bool
    {
        if(!$email && !$password && $this->exists()) {
            Session::put($this->sessionName, $this->data()->id);
        } else {
            $user = $this->find($email);

            if ($user) {
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    Session::put($this->sessionName, $this->data()->id);
                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->database->get('users_session', array('user_id', '=', $this->data()->id));
                        if (!$hashCheck->count()) {
                            $this->database->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->cookieName, $hash, Config::COOKIE_EXPIRY);
                    }
                    return true;
                }
            }
        }
        return false;
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