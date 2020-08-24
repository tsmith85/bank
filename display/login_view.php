<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    ini_set('error_reporting', E_ALL);
    require_once "../user/Login.php";
    // start the session
    session_start();
    // check if form has been submitted
    \user\Login::checkLoginPressed();
    // generate token for form
    \user\Login::generate_token();
    
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Credentials</title>
    </head>
    <body> 
        <form method="POST" name="login_form">
            <input type="hidden" name="token" value=<?php echo $_SESSION['internal_token']; ?> />
            <input type="text" placeholder="Login Name" name="login_name" value="" /><br />
            <input type="password" placeholder="Password" name="password" value="" /><br />
            <input type="submit" name="log_in" value="Login">
        </form>
        
        <?php echo \user\Login::$msg; ?>
    </body>
</html>
