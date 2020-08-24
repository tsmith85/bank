<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace user;
require_once "../user/User.php";
/**
 * Contains the queries to select a user and display their details
 *
 * @author tom
 */
class User_Query {
    //put your code here
    public static function selectUser(int $user_id) {
        \db\ConnectDB::connect('Bank');
        
        $user_id_escape = mysqli_real_escape_string(\db\ConnectDB::$link, $user_id);       
        
        $qry_user = "SELECT `First_Name`, `Surname` FROM `User` "
                . "WHERE `UserID` = ?";
        
        $bind = mysqli_prepare(\db\ConnectDB::$link, $qry_user);
        $bind->bind_param("i", $user_id_escape);    
        $bind->execute();
        
        $result = $bind->get_result();
        
        // check if result returns a row, if so set name
        if(mysqli_num_rows($result) > 0) {
            // loop through and get name
            while ($row = mysqli_fetch_assoc($result)) {
                $name = array("First Name" => htmlentities($row['First_Name']),
                    "Surname" => htmlentities($row['Surname']));
            }
        }
        
        \db\ConnectDB::disconnect();
        
        return $name;
    }
}
