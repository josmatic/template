<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/header.php';

if(empty($_POST) === false)
{
    $required_fields = array('username', 'password', 'repeat_password', 'first_name', 'e_mail');
    foreach($_POST as $key=>$value)
    {                               //this is Associative Arrays http://www.w3schools.com/php/php_arrays.asp
        if(empty($value) && in_array($key, $required_fields) === true)
        {
            $errors[] = 'Fields marked with an asterisk are required';
            break 1;
        }
    }
    if (empty($errors) === true)
    {
        if(user_exists($_POST['username']) === true)
        {
            $errors[] = "Sorry, the username '".htmlentities($_POST['username'])."' is already taken";
        }
        if(preg_match("/\\s/", $_POST['username']) == true) //with '==' we don't check type of data
        {
            $errors[] = 'Your username must not contain any spaces';
        }
        /*More about about preg_match function http://php.net/manual/en/function.preg-match.php
        \s     Any whitespace character
        \S     Any non-whitespace character
        \d     Any digit
        \D     Any non-digit*/
        if(strlen($_POST['password'])<6)
        {
            $errors[] = 'Your password must be at least 6 characters';
        }
        elseif(strlen($_POST['password'])>32)
        {
            $errors[]='You password must me be less then 33 characters';
        }
        if($_POST['password'] !== $_POST['repeat_password']) //!== mean not identical
        {
               $errors[] = 'Your passwords do not match';
        }
        if(filter_var($_POST['e_mail'], FILTER_VALIDATE_EMAIL) === false)
        {
            $errors[] = 'A valid email address is required';
        }
        if(email_exists($_POST['e_mail']) === true)
        {
            $errors[] = "Sorry the email '" . $_POST['e_mail']."' is already in use";
        }

    }
}
?>
    <h1>Register</h1>
<?php
if(isset($_GET['success']) && empty($_GET['success']))
{
    echo "You have been registered successfully!";
}
else
{
    if(empty($_POST) === false && empty($errors) ===true)
    {
        $register_data = array(
            'username'      => $_POST['username'],
            'password'      => $_POST['password'],
            'first_name'    => $_POST['first_name'],
            'last_name'     => $_POST['last_name'],
            'e_mail'        => $_POST['e_mail']
        );  //this is end of array

        register_user($register_data);
        header('Location: register.php?success');
        //exit
    }
    else if (empty($errors) === false)
    {
        echo output_errors($errors);
    }
?>
    <form action="" method="POST">
    <ul>
        <li>
            Username*:<br>
            <input type="text" name="username">
        </li>
        <li>
            Password*:<br>
            <input type="password" name="password">
        </li>
        <li>
            Repeat password*:<br>
            <input type="password" name="repeat_password">
        </li>
        <li>
            First name*:<br>
            <input type="text" name="first_name">
        </li>
        <li>
            Last name:<br>
            <input type="text" name="last_name">
        </li>
        <li>
            E-mail*:<br>
            <input type="text" name="e_mail"><br>
        </li>
        <li>
            <input type="submit" value="Register">
        </li>
    </ul>
    </form>
<?php
 }
        include 'includes/overall/footer.php'
        ?>