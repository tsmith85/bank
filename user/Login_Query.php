<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace user;

require_once "../db/ConnectDB.php";
/**
 * Contains all the queries we will need to validate a user login
 *
 * @author tom
 */
class Login_Query {
    // Empty Constructor
    
    function __construct() {}
    
    // Get details user entered
    public static function selectLoginDetail(string $login_name, string $password) {        
        
        // Connect to database Bank
        \db\ConnectDB::connect('Bank');
                
        // Escape strings so can be safely used in SQL (SQL injection)
        $login_name_escape = mysqli_real_escape_string(\db\ConnectDB::$link, $login_name);
        $password_escape = mysqli_real_escape_string(\db\ConnectDB::$link, $password);
        
        $password_encrypt = sha1($password_escape);
        
        // Query to select UserID, to add to session if successful
        $qry_login = "SELECT `UserID` FROM Login "
                . "WHERE Login_Name = ? && Password = ?";
        
        $bind = mysqli_prepare(\db\ConnectDB::$link, $qry_login);
        $bind->bind_param("ss", $login_name_escape, $password_encrypt); 
        $bind->execute();
        
        $result = $bind->get_result();
        
        // check if result returns a row, if so set userID else set to null
        if(mysqli_num_rows($result) > 0) {
            // loop through and get UserID
            while ($row = mysqli_fetch_assoc($result)) {
                $userID = htmlentities($row['UserID']);
            }
        } else {
            $userID = null;
        }
        
        // Disconnect from database
        \db\ConnectDB::disconnect();
        
        // return userID
        return $userID;
    }
}
