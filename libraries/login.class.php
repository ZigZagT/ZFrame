<?php
defined('_ZEXEC') or die;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author master
 */
class Login
{

    public $secret;
    public $requirePath;
    

    public function requireLoginSimple()
    {
        $loginMessage = "";
        if (!isset($_COOKIE['requireLogin']) || $_COOKIE['requireLogin'] == 1)
        {
            if (isset($_POST['secret']) && $_POST['secret'] == $this->secret)
            {
                setcookie('requireLogin', 0, time() + 3600);
                require_once $this->requirePath;
                exit;
            } elseif (isset($_POST['secret']) && !empty($_POST['secret']))
            {
                $loginMessage = 'invalid password.';
            }
            $this->showLoginWindow($loginMessage);
        } else
        {
            require_once $this->requirePath;
            exit;
        }
    }

    private function showLoginWindow($Message)
    {
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title></title>
            </head>
            <body>
                <?php
                if (isset($Message) && !empty($Message))
                {
                    ?>
                    <div>
                        <?php echo $Message ?>
                    </div><?php } ?>
                <div>
                    <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" target="_self">
                        <input type="password" name="secret">
                        <input type="submit" content="login">
                    </form>
                </div>
            </body>
        </html>
        <?php
    }

}
