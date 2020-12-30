<?php
// VISIONair pages
$home       = 'view/home.php';
$customers  = 'view/customers.php';


$page = isset($_GET['page'])?$_GET['page']:$home;
$pages = array($home, $customers);

if (!empty($page))
{
    if (in_array($page, $pages)) {
        require_once($page);
    }
    else
    {
        echo 'Page not found. 404';
    }
} else {
    require_once ($home);
}

