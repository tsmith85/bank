<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace user;
require_once "../user/User_Query.php";

/**
 * Class to store all user details
 *
 * @author tom
 */
class User {
    private int $user_id;
    private string $first_name;
    private string $surname;
    
    function __construct(int $user_id) {
        $this->user_id = $user_id;
    }
    
    // set the first name of the added user
    public function setFirstName(string $first_name) {
        $this->first_name = $first_name;
    }
    
    // set the surname of the added user
    public function setSurname(string $surname) {
        $this->surname = $surname;
    }
    
    // get the user details via the user ID
    public static function getUser(int $user_id) {
        $name = \user\User_Query::selectUser($user_id);
        
        return $name;
    }
}
