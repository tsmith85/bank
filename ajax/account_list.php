<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../account/Account.php";

session_start();

$accounts = \account\Account::getAccounts($_SESSION['user']);

$_SESSION['accounts'] = $accounts;

?>

<div id="account_list">
    <table class="account_list_tbl">
        <caption>List of Accounts</caption>
        <thead>
            <tr>
                <th>Account No</th>
                <th>Account Name</th>
                <th>Amount</th>
                <th>Overdraft Limit</th>
            </tr>
        </thead>
        <tbody onclick="accountDetail();">
            <?php foreach ($accounts as $a) { ?>
            <tr>
                <td><?php echo $a['Account No']; ?></td>
                <td><?php echo $a['Account Name']; ?></td>
                <td>£<?php echo (float)$a['Amount']; ?></td>
                <td>£<?php echo $a['Overdraft Limit']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

