<?php


namespace app\controller;


use app\model\User;

class Session
{
    public function __construct()
    {
        if(Cookie::exists(Config::COOKIE_NAME) && !self::exists(Config::SESSION_NAME)) {
            $hash = Cookie::get(Config::COOKIE_NAME);
            $hashCheck = Database::getInstance()->get('users_session', array('hash', '=', $hash));

            if($hashCheck->count()) {
                $user = new User($hashCheck->first()->user_id);
                $user->login();
            }
        }
    }

    public static function exists($name): bool
    {
        return isset($_SESSION[$name]);
    }

    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    public static function get($name) {
        return $_SESSION[$name];
    }

    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function flash ($name, $string = 'null') {
        if(self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
        return false;
    }

}