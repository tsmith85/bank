<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    require_once "../user/User.php";
    require_once "../user/Login.php";
    // start the session
    session_start();
    // check if log out is pressed
    \user\Login::checkLogOutPressed();
    // Check session information is active
    \user\Login::validate_session();
?>

<html>
    <head>
        <link rel="stylesheet" href="../css/main.css" />
        <link rel="stylesheet" href="../css/sidebar.css" />
        <link rel="stylesheet" href="../css/account_detail.css" />
        <link rel="stylesheet" href="../css/account_list.css" />
        <link rel="stylesheet" href="../css/customer_view.css" />
        <script src="../assets/jquery.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/customer.js"></script>
        <meta charset="UTF-8">
        <title>Customer</title>
    </head>
    <body onload="loadAjax();">
        <?php
            include_once "../display/sidebar_nav.php";
        ?>
        
        <div id="load_accounts"></div>
    </body>
</html>
