<?php

//load up db_credentials file once 
require_once('db_credentials.php');


//connect to the database using mysqli
function db_connect(){
    
    $connection = mysqli_connect(DB_SERVER, DB_USER, 
            DB_PASS, DB_NAME);
    
    //error check
    confirm_db_connect();
    
    return $connection;
}

//close the database connection using mysqli
function db_disconnect($connection){
    
    if(isset($connection)){
        mysqli_close($connection);
    }
}

//if connection to database failed show the error message
function confirm_db_connect(){
    if(mysqli_connect_errno()){
        $msg = "Database connection failed: ";
        $msg = mysqli_connect_error();
        $msg = " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }
}

//check if the 'SELECT' query returns data set 
function confirm_result_set($result_set){
    if(!$result_set){
        exit("Database query failed");
    }
}

//function used for preventing SQL injection attacks
function db_escape($connection, $string){
    return mysqli_real_escape_string($connection, $string);
}
?>

