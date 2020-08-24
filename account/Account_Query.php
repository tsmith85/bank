<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace account;
require_once "../db/ConnectDB.php";

/**
 * Holds all the queries to any action to an account, i.e. amounts withdrawn and deposited
 *
 * @author tom
 */
class Account_Query {
    // Code to update users accounts when a inside transfer is made
    public static function updateAmount(int $account_no, float $amount) {
        \db\ConnectDB::connect('Bank'); 
        
        $account_no_escape = mysqli_real_escape_string(\db\ConnectDB::$link, $account_no);
        $amount_escape = mysqli_real_escape_string(\db\ConnectDB::$link, round($amount, 2)); 
        
        $qry_amount = "UPDATE Account SET Amount = ? "
                . "WHERE Account_No = ?";
        
        $bind = mysqli_prepare(\db\ConnectDB::$link, $qry_amount);
        $bind->bind_param("di", $amount_escape, $account_no_escape);    
        $bind->execute();
               
        \db\ConnectDB::disconnect();
    }
    
    // get list of accounts belonging to the user logged in
    public static function selectAccounts(int $user_id) {
        \db\ConnectDB::connect('Bank');
        $user_id_escape = mysqli_real_escape_string(\db\ConnectDB::$link, $user_id);
        
        $qry_account = "SELECT `Account_No`, `Account_Name`, `Amount`, `Overdraft_Limit` FROM "
                . "`Account` INNER JOIN `User` ON Account.UserID = User.UserID "
                . "INNER JOIN `Account_Type` ON "
                . "Account.Account_TypeID = Account_Type.Account_TypeID " 
                . "WHERE Account.`UserID` = ?";
        
        $bind = mysqli_prepare(\db\ConnectDB::$link, $qry_account);
        $bind->bind_param("i", $user_id_escape); 
        $bind->execute();
        
        $result = $bind->get_result();
        
        $i = 0;
        
        // check if result returns a row, if so set an array of accounts
        if(mysqli_num_rows($result) > 0) {
            // loop through setting to array with the accounts
            while ($row = mysqli_fetch_assoc($result)) {
                $accounts[$i] = array("Account No" => htmlentities($row['Account_No']),
                    "Account Name" => htmlentities($row['Account_Name']),
                    "Amount" => htmlentities($row['Amount']),
                    "Overdraft Limit" => htmlentities($row['Overdraft_Limit']));
                
                $i++;
            }
        }
        
        \db\ConnectDB::disconnect();
        
        return $accounts;
    }
    
    // get the amount for the given user and account
    public static function selectAmountOverdraft(int $account_no) {
        \db\ConnectDB::connect('Bank');
        $account_no_escape = mysqli_real_escape_string(\db\ConnectDB::$link, $account_no);
                
        $qry_amount = "SELECT `Amount`, `Overdraft_Limit` FROM "
                . "`Account` INNER JOIN `User` ON Account.UserID = User.UserID "
                . "INNER JOIN `Account_Type` ON "
                . "Account.Account_TypeID  = Account_Type.Account_TypeID " 
                . "WHERE `Account_No` = ?";
        
        $bind = mysqli_prepare(\db\ConnectDB::$link, $qry_amount);
        $bind->bind_param("i", $account_no_escape);       
        $bind->execute();
        
        $result = $bind->get_result();
        
        // check if result returns a row, if so set an array of accounts
        if(mysqli_num_rows($result) > 0) {
            // loop through setting to array with the accounts
            while ($row = mysqli_fetch_assoc($result)) {
                $amount = array("Amount" => htmlentities($row['Amount']),
                    "Overdraft" => htmlentities($row['Overdraft_Limit']));
            }
        }
        
        \db\ConnectDB::disconnect();
        
        return $amount;
    }
    
    // check to see if the account exists
    public static function selectAccountExists(int $account_no) {
        \db\ConnectDB::connect('Bank');
        $account_no_escape = mysqli_real_escape_string(\db\ConnectDB::$link, $account_no);
        
        $qry_account = "SELECT COUNT(0) AS `Count` FROM "
                . "`Account` WHERE `Account_No` = ?";
        
        $bind = mysqli_prepare(\db\ConnectDB::$link, $qry_account);
        $bind->bind_param("i", $account_no_escape);       
        $bind->execute();
        
        $result = $bind->get_result();
        
        // check if result returns a row, if so set count
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $count = htmlentities($row['Count']);
        }
        
        \db\ConnectDB::disconnect();
        
        return $count;
    }
}
