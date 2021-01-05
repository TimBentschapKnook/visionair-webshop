<?php

use app\model\User;

require_once __DIR__ . '/vendor/autoload.php';

$user = new User();

?>

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
    <header>
        <nav>
            <ul>
                <li id="home">
                    <a href="?page=view/home.php">
                        <span class="material-icons">
                            dashboard
                        </span>
                    </a>
                </li>
                <li id="customers">
                    <a href="?page=view/customers.php">
                        <span class="material-icons">
                            group
                        </span>
                    </a>
                </li>
                <li id="orders">
                    <a href="?page=view/orders.php">
                        <span class="material-icons">
                            add_shopping_cart
                        </span>
                    </a>
                </li>
                <li id="signOut">
                    <a href="logout.php">
                        <span class="material-icons">
                            trending_up
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="header">
            <div class="container">
                <div class="col-md-12">
                    <!-- Hier moet nog iets van leuke content komen-->
                </div>
            </div>
        </div>
        <?php
            $home       = 'view/home.php';
            $customers  = 'view/customers.php';
            $orders  = 'view/orders.php';


            $page = isset($_GET['page'])?$_GET['page']:$home;
            $pages = array($home, $customers, $orders);

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

        ?>
    </main>
    <script type="text/javascript" src="resources/js/jquery.min.js"></script>
    <script type="text/javascript" src="resources/js/script.js"></script>
    <script type="text/javascript" src="resources/js/material-components-web.min.js"></script>
    <script type="text/javascript" src="resources/js/charts.min.js"></script>
    <script type="text/javascript" src="resources/js/chart.js"></script>
</body>
</html>
