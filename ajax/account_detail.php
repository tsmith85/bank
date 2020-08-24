<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../account/Account.php";

session_start();

$account_no = filter_input(INPUT_GET, "account");
$acc_obj = new \account\Account($account_no);
$amount = $acc_obj->getAmount();

$_SESSION['acc_obj'] = $acc_obj;
$accounts = $_SESSION['accounts'];

?>

<div>
    <label>Account No:</label>
    <label id="account_no"><?php echo $account_no; ?></label><br />
    
    <label>Amount:</label>
    <label>£<?php echo $amount; ?></label><br />
</div>

<div class="txt_header">Transfer to another account you hold</div>
<div>
    <label>Transfer To: </label>
    <select name="account_list_cmb" id="account_list_cmb">
        <?php foreach ($accounts as $a) { 
        if ($account_no !== $a['Account No']) {    
        ?>
        <option><?php echo $a['Account No']; ?></option>
        <?php }
        }
        ?>
    </select>
    <label>Amount: </label>
    <input type="text" name="transfer_amount" id="transfer_amount" />
    <input type="button" name="transfer" value="Transfer" onclick="submitTransfer();" />
</div>
<div class="txt_header">Transfer to a new person</div>

<table>
    <thead>
        <tr>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Account Holder:</td>
            <td><input type="text" name="transfer_name" id="transfer_name" /></td>
        </tr>
        <tr>
            <td>Account No:</td>
            <td><input type="text" name="transfer_account_no" id="transfer_account_no" value="" /></td>
        </tr>
        <tr>
            <td>Amount:</td>
            <td><input type="number" name="transfer_amount_person" id="transfer_amount_person" value="0" /></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:right;"><input type="button" name="transfer_person" value="Transfer" onclick="submitTransferPerson();" /></td>
        </tr>
    </tbody>
</table>

<div id="transfer_status"></div>




