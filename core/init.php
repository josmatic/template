<?php
session_start();
//error_reporting(0); //error not display (error as syntax and semantic)!
require 'database/connect.php';
require 'function/general.php';
require 'function/users.php';

if (logged_in() === true)   //for true user is logged in
{
    $session_user_id = $_SESSION['user_id']; //we get 'user_id' for logged user
    $user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'first_name', 'last_name', 'e_mail');
    /*user_data is function that send a parameters for query (and much more) for logged user*/
    if(user_active($user_data['username']) === false) //false, user isn't active (0 in database)
    {
        session_destroy();
        header('Location: index.php');
        /*user is logged in, but for some reason in database change for active row from 1 to 0
        that will destroy session (user will be logout) and redirected. Script stop work with exit()*/
        exit();
    }
}
else
{
    //user isn't loggedin
}
$errors = array();
?>