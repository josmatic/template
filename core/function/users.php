<?php
function activate($email, $email_code)
{
    $email          = mysql_real_escape_string($email); //mysql_real_escape_string — Escapes special characters in a string for use in an SQL statement
    $email_code     = mysql_real_escape_string($email_code);//mysql_real_escape_string

    if(mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `e_mail` = '$email' AND `e_mail_code` = '$email_code' AND `active` = 0"), 0) == 1)
    {
        mysql_query("UPDATE `users` SET `active` = 1 WHERE `e_mail` = $email");
        echo "trueeeeee";
        sleep(1);
        return true;
    }
    else
    {
        echo "falseeeee";
        return false;
    }
}
function change_password($user_id, $password)
{
    $user_id=(int)$user_id;    //simple sanatize user_id because that can be only integer
    $password = md5($password); //hash to md5
    mysql_query("UPDATE `users` SET `password` = '$password' WHERE `user_id` = $user_id");
}
function register_user($register_data)
{
    array_walk($register_data, 'array_sanitize');
    $register_data['password'] = md5($register_data['password']);

    $fields = "`" . implode("`, `", array_keys($register_data)) . '`';  //look like this `username`, `password`, etc
    $data = " \"" . implode("\", \"", $register_data)."\""; //this is what user enter in username, md5(password) etc.
    //echo "fields:" . ($fields).'<br>'." and data: " . $data . '<br>';

    mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
    email($register_data['e_mail'], 'Activate your account', "Hello " . $register_data['first_name'] .",\n\nYou need to activate your account, so use the link below:\n\nhttp://localhost/template/activate.php?e_mail=" . $register_data['e_mail'] . "&e_mail_code=" . $register_data['e_mail_code'] . "\n\n- Povezi me - by Josip Matic");

}
function user_count()   //return count active user (in database `active`=1)
{
    return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active`=1"), 0);
}
function user_data($user_id)
{
    $data = array();
    $user_id = (int)$user_id;   //sanatize with int

    $func_num_args = func_num_args();   //number of parametars in array
    $func_get_args = func_get_args();

    if($func_get_args > 1);     //if user is logged in this is true
    {
        unset($func_get_args[0]); //array with position one don't "show" that is 'user_id'

        $fields = '`' . implode('`, `', $func_get_args ) . '`';
        //for implode we insert end, and start char '`' ind the "middle"
        $data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id`= $user_id"));
        return $data;   //retrun all data of user
    }
}
function logged_in()
{
    /*if(isset($_SESSION['user_id']) === true)
    {
        echo 'Session user_id '.$_SESSION['user_id'].'<br>';
        echo "Korisnik se prijavio u sustav!".'<br>';
        return true;
    }
    elseif(isset($_SESSION['user_id']) === false)
    {
        echo "Korisnik nije prijavljen u sustav".'<br>';
        return false;
    }
    // or use this bellow*/
    return (isset($_SESSION['user_id'])) ? true : false;
}
function user_exists($username)
{
    $username = sanitize($username);    //add securty
    $result = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username`='$username'");
    return (mysql_result($result, 0)==1) ? true : false;
}
function email_exists($email)
{
    $email = sanitize($email);    //add securty
    $result = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `e_mail`='$email'");
    return (mysql_result($result, 0)==1) ? true : false;
}
function user_active($username)
{
    $username = sanitize($username);
    $result = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE (`username`='$username' AND `active`=1)");
    return (mysql_result($result, 0)==1) ? true : false;
}
function user_id_from_username ($username)
{
    $username = sanitize($username);
    return mysql_result(mysql_query("SELECT user_id FROM users WHERE username = '$username'"), 0, 'user_id');
}
function login($username, $password)
{
    $user_id = user_id_from_username($username);
    $username = sanitize($username);
    $password = md5($password);
    $result = mysql_query("SELECT COUNT(user_id) FROM users WHERE username='$username' AND password='$password'");
    return (mysql_result($result, 0)==1) ? $user_id : false;
}
   /* if($result) //true
    {
        //$redak = mysql_fetch_array( $result );
        echo "Name: ".$redak['user_id'];
        echo "Name: ".$redak['first_name'];
        echo " Lastname: ".$redak['last_name'];

        return (mysql_result($result, 0) == 1);
    }
    else    //false
    {
        echo "ERROR QUERY!".'<BR>';
    }*/
    //return (mysql_result($result, 0) == 1) ? true : false;
    /*
    return as if else...if statemanet is true, or false
    statement:
        return () ? true : false;
    if result of query is equal 1 statement is true (user exist), other ways are false (user doesn't exist)
    */

?>