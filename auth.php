<?php
use app\controller\Token;
use app\controller\Input;
use app\controller\Validate;
use app\model\User;
use app\controller\Redirect;

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
                require_once('dashboard.php');
            } else {
                echo 'Incorrect email or password';
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
</body>
</html>