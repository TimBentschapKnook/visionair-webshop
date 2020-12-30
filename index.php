<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height"/>
    <title>VISIONair</title>
    <link rel="icon" href="resources/images/favicon.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="resources/css/material-components-web.min.css" rel="stylesheet">
    <link rel="stylesheet" href="resources/scss/style.css" />
</head>
<body>
<?php

use app\model\User;

require_once __DIR__ . '/vendor/autoload.php';

$user = new User("Tim", "Bentschap Knook", '0638928320', "timbknook@gmail.com", "Diesel.com3");

if (!$user->isAuthenticated()) {
    require_once "view/layouts/auth.php";
} else {
    require_once "view/layouts/dashboard.php";
}

?>
<script type="text/javascript" src="resources/js/jquery.min.js"></script>
<script type="text/javascript" src="resources/js/script.js"></script>
<script type="text/javascript" src="resources/js/material-components-web.min.js"></script>
<script type="text/javascript" src="resources/js/charts.min.js"></script>
<script type="text/javascript" src="resources/js/chart.js"></script>
</body>
</html>

