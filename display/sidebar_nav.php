
<?php 
    // check if just logged out
    \user\Login::checkLogOutPressed();
    
    // get User ID from session
    $name = \user\User::getUser($_SESSION['user']);
?>

<div id='sidebar'>
    <center>
    <p><label><?php echo $name['First Name']." ".$name['Surname']; ?></label>
    <p><label>Account: <?php echo $_SESSION['login_name']; ?></label></p>
    </center>
    <a href="../display/customer_view.php">Accounts</a>
    <a href=<?php echo $_SERVER['PHP_SELF']; ?>?logout=true>Log Out</a> 
</div>
