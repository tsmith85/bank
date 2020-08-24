<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../account/Account.php";

session_start();

$account_no = filter_input(INPUT_GET, "account");
$transfer_amount = filter_input(INPUT_GET, "amount");
$transfer_to = filter_input(INPUT_GET, "transfer");


if((int)$transfer_amount <= 0) {
    echo "Please provide an amount greater than 0 to transfer!";
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

