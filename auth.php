<?php
use app\controller\Token;
use app\controller\Input;
use app\controller\Validate;
use app\model\User;
use app\controller\Redirect;

require_once __DIR__ . '/vendor/autoload.php';

session_start();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validate->check($_POST, array(
                'username' => array('required' => true),
                'password' => array('required' => true)
        ));

        if ($validate->passed()) {
            $user = new User();

            $remember = Input::get('remember') === 'on';
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if ($login)
            {
                Redirect::to('dashboard.php');
            } else {
                echo 'Incorrect username or password';
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}

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
    <main class="auth">
        <div class="overlay"></div>
        <div class="box">
            <div>
                <h3>Title</h3>
            </div>
            <div class="form">
                <form action="" method="post">
                    <div class="field">
                        <label for='username'>Username</label>
                        <input type="text" name="username" id="username">
                    </div>

                    <div class="field">
                        <label for='password'>Password</label>
                        <input type="password" name="password" id="password">
                    </div>

                    <div class="field">
                        <label for="remember">
                            <input type="checkbox" name="remember" id="remember">Remember me
                        </label>
                    </div>

                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <input type="submit" value="Login">
                </form>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="resources/js/jquery.min.js"></script>
    <script type="text/javascript" src="resources/js/script.js"></script>
    <script type="text/javascript" src="resources/js/material-components-web.min.js"></script>
    <script type="text/javascript" src="resources/js/charts.min.js"></script>
    <script type="text/javascript" src="resources/js/chart.js"></script>
</body>
</html>