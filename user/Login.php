<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace user;

require_once "../user/Login_Query.php";

/**
 * Description of Login
 *
 * Class to check users credentials, and validate against table 
 * 
 * @author tom
 */
class Login {
    
    public static string $msg = "";
    
    //Constructor is empty
    function __construct() {}
    
    // Check to see if log in button is pressed
    public static function checkLoginPressed() {
        // check for CSRF, only submit if token is valid, and submit is pressed
        if(filter_input(INPUT_POST, 'log_in') !== NULL) {
            // validate login information
            (self::validate_token()) ? self::validate_login() : NULL;
        }
    }
    
    // Check to see if Log Out button pressed
    public static function checkLogOutPressed() {
        if(filter_input(INPUT_GET, 'logout') !== NULL) {
            // unset all session variables
            session_unset();
            // clear session
            session_destroy();
            // go to login page when logged out
            header("Location: ../display/login_view.php");
        }
    }
    
    // check given login name and password and match to see if correct
    private static function validate_login() {
        $login_name = filter_input(INPUT_POST, 'login_name');
        $password = filter_input(INPUT_POST, 'password');
        
        $user_id = \user\Login_Query::selectLoginDetail($login_name, $password);
        
        if(isset($user_id)) {
            $_SESSION['user'] = $user_id;
            $_SESSION['login_name'] = $login_name;
            header("Location: ../display/customer_view.php");
        } else {
            self::$msg = "Invalid Username or Password!";
        }
    }

    // check if session is valid
    public static function validate_session() {
        if(!isset($_SESSION['user'])) {
            session_unset();
            session_destroy();
            header("Location: ../display/login_view.php");
        }
    }
    
    // Token for Cross-Site Request Forgery protection
    public static function generate_token() {
        $_SESSION['internal_token'] = bin2hex(random_bytes(24));
        hash_hmac('sha256', 'login_form', $_SESSION['internal_token']);
    }
    
    // validate token
    private static function validate_token() {
        if(hash_equals($_SESSION['internal_token'], filter_input(INPUT_POST, 'token'))) {
            return true;
        } else {
            return false;
        }
    }
}
