<?php

namespace app\controller;



use app\model\User;

class Config
{
    const DB_HOST = 'localhost';
    const DB_NAME = 'webshop';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';
    const SESSION_NAME = 'user';
    const TOKEN_NAME =  'token';
    const COOKIE_NAME =  'hash';
    const COOKIE_EXPIRY =  604800;

    public function __construct()
    {

    }
}

