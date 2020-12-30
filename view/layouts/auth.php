<?php
use app\controller\Token;
use app\controller\Input;
use app\controller\Validate;
use app\model\User;
use app\controller\Redirect;

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validate->check($_POST, array(
                'email' => array('required' => true),
                'password' => array('required' => true)
        ));

        if ($validate->passed()) {
            $user = new User();
            $remember = Input::get('remember') === 'on';
            $login = $user->login(Input::get('email'), Input::get('password'), $remember);

            if ($login)
            {
                Redirect::to('index.php');
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
            <div class="header">
                <h3>Title</h3>
            </div>
            <div class="form">
                <form method="post">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <label for="password">Wachtwoord:</label>
                                <input type="password" name="password" id="password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <label for="remember"></label>
                                <input type="checkbox" name="remember" id="remember">Remember me
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 offset-1">
                                <button type="submit" class="button primary" name="login">Inloggen</button>
                                <button class="button">Wachtwoord vergeten</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>