<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../account/Account.php";

session_start();

$empty_field = false;
$account_exists = false;
$account_no = filter_input(INPUT_GET, "account");
$transfer_amount = filter_input(INPUT_GET, "amount");
$transfer_to = filter_input(INPUT_GET, "transfer");

// run validation to check if account and amount are a number
if(!preg_match('/^\d{8}$/', $transfer_to)) {
    echo "Incorrect format for an amount to transfer!";
    exit;
}

if(!is_numeric($transfer_amount)) {
    echo "Incorrect format for an amount to transfer!";
    exit;
}

// run validation check to see if fields filled in
if((int)$transfer_to <= 0) {
    echo "Please provide an account number to transfer to!<br />";
    $empty_field = true;
}

if((int)$transfer_amount <= 0) {
    echo "Please provide an amount greater than 0 to transfer!";
    $empty_field = true;
}

if($empty_field === true) {
    exit;
}

// check if account given exists
$account_exists = \account\Account::checkAccountExists($transfer_to);

if($account_exists === false) {
    echo "Account doesn't exists, please check and try again!";
    exit;
}


$acc_obj = $_SESSION['acc_obj'];
$acc_obj2 = new \account\Account($transfer_to);

$amount = $acc_obj->getAmount();
$overdraft_limit = $acc_obj->getOverdraftLimit();

// check if there are available funds
if(($amount + $overdraft_limit) >= $transfer_amount) {
    // debit the account transferred from
    $acc_obj->debit($account_no, $transfer_amount);
    // credit to account transferred to
    $acc_obj2->credit($transfer_to, $transfer_amount);

    echo "Successfully Transferred!";
} else {
    echo "invalid funds!";
}
