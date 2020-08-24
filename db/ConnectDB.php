<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace db;

/**
 * Description of ConnectDB
 *
 * @author tom
 */
class ConnectDB {
    
    private static string $server = 'localhost';
    private static string $username = 'Customer';
    private static string $password = 'bank001';
    public static $link;
    
    function __construct() {}
    
    // connect to the main database
    public static function connect(string $db) {
        // Connection string, to connect to the mysql database
        self::$link = mysqli_connect(self::$server, self::$username, self::$password, $db);
        
        // check to see if connection is successful
        if (mysqli_connect_errno()) {
            die('Could not connect: ' . mysqli_connect_error());
        } 
    }
    
    //disconnect from the main database
    public static function disconnect() {
        mysqli_close(self::$link);
    }
}
