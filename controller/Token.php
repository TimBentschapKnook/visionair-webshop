<?php


namespace app\controller;


class Token
{
    public static function generate()
    {
        return Session::put(Config::TOKEN_NAME, md5(uniqid()));
    }

    public static function check($token): bool
    {
        $tokenName = Config::TOKEN_NAME;

//        if (Session::exists($tokenName) && $token === Session::get($tokenName))
        if ($token === Session::get($tokenName))
        {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}