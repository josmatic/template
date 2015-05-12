<?php
$connection_error = 'Sorry, please try again later.';
@mysql_connect('localhost','root','') or die($connection_error);
mysql_select_db('login_database') or die($connection_error);
//echo "Spojeno na bazu".'<br>';

/*
 * UPDATE `login_database`.`users` SET `password` = MD5('celija') WHERE `users`.`id` = 5;
 * */
?>