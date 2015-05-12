<?php
include 'core/init.php';

if(empty($_POST) === false)
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(empty($username) === true || empty($password) === true) // empty username or password
    {
        $errors[] = 'You need to enter a username and password';
    }
    elseif(user_exists($username) === false)//
    {
        $errors[] = 'We can\'t find that username. Have you registered?' ;
    }
    elseif(user_active($username) === false)//
    {
        $errors[] = 'You haven\'t activated your acount';
    }
    else
    {
        if(strlen($password) >32)
        {
            $errors[] = 'Password too long';
        }

        $login = login($username, $password);
        if($login === false)
        {
            $errors[] = 'That username/password combination is incorrect';
        }
        else
        {
            $_SESSION['user_id']=$login;
            header('Location: index.php');
            exit();
        }
    }


}
else
{
    $errors[] = "No data received";
}

include 'includes/overall/header.php';
if (empty($errors) === false)
{
    echo "<h2>We tried to log in, but...</h2>";
    echo output_errors($errors);
}

include 'includes/overall/footer.php';
?>