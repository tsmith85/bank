<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace account;
require_once "../account/Account_Query.php";

/**
 * Class for storing all account details, listing accounts and updating the accounts
 *
 * @author tom
 */
class Account {
    private int $account_no;
    private float $amount;
    private int $overdraft_limit;
    
    function __construct(int $account_no) {
        $this->account_no = $account_no;
        $this->setAmountOverdraft();
    }
    
    // sets the account number for an added new account
    public function setAccountNo(int $account_no) {
        $this->account_no = $account_no;
    }
    
    // set the amount and overdraft limit
    public function setAmountOverdraft() {
        $amountoverdraft = \account\Account_Query::selectAmountOverdraft($this->account_no);
    
        $this->amount = $amountoverdraft['Amount'];
        $this->overdraft_limit = $amountoverdraft['Overdraft'];
    }

    // get the overdraft limit for the account
    public function getOverdraftLimit() {
        return $this->overdraft_limit;
    }
    
    // get the amount of money in the account
    public function getAmount() {
        return $this->amount;
    }
    
    // debit the account, passing the account number and by how much
    public function debit(int $account_no, float $debit) {
        ($debit <= ($this->amount + $this->overdraft_limit)) ? $this->amount -= $debit : null;
        $this->updateAmount($account_no);
        $this->setAmountOverdraft();
    }
    
    // credit an account, passing the account number and how much money to be added
    public function credit(int $account_no, float $credit) {
        $this->amount += $credit;
        $this->updateAmount($account_no);
        $this->setAmountOverdraft();
    }
    
    // update the amount of money in account, passing the account number parameter
    private function updateAmount(int $account_no) {
        \account\Account_Query::updateAmount($account_no, $this->amount);
    }

    // get a list of accounts for the given user
    public static function getAccounts(int $user_id) {
        $accounts = \account\Account_Query::selectAccounts($user_id);

        return $accounts;
    }
    
    // check if account already exists, passing the ccount number parameter
    public static function checkAccountExists(int $account_no) {
        $count = \account\Account_Query::selectAccountExists($account_no);
        
        ($count > 0) ? $exists = true : $exists = false;
        
        return $exists;
    }
}
