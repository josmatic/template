<?php
include 'core/init.php';
protected_page();

if(empty($_POST) ===false)
{
    $required_fields = array('current_password', 'password', 'password_again');
    foreach($_POST as $key=>$value)
    {                               //this is Associative Arrays http://www.w3schools.com/php/php_arrays.asp
        if(empty($value) && in_array($key, $required_fields) === true)
        {
            $errors[] = 'Fields marked with an asterisk are required';
            break 1;    //exit from that {} where is break
        }
    }

    if(md5($_POST['current_password']) === $user_data['password'])
    {
        if(trim($_POST['password']) !== trim($_POST['password_again'])) //trim() delete white space from left nad from right side of string, but not in middle of string
        {
            $errors[] = "Your new password don't match";
        }
        else if(md5($_POST['password']) === md5($_POST['current_password'])) //we already check password form database in first if statement
        {
            $errors[] = "Your new password need different from current password";
        }
        else if(strlen($_POST['password'])<6)
        {
            $errors[] = 'Your new password must be at least 6 characters';
        }
        else if(strlen($_POST['password'])>32)
        {
            $errors[]='Your new password must me be less then 33 characters';
        }
    }
    else
    {
        $errors[]='Your current password is incorrect';
    }

}include 'includes/overall/header.php'
?>
    <h1>Promijeni password/šifru</h1>

<?php
if(isset($_GET['success']) && empty($_GET['success']))  //GET from catch from right to left until come to '?'
{
    echo "You have changed password successfully!";
}
else
{
    if(empty($_POST) === false && empty($errors) ===true)
    {
        change_password($_SESSION['user_id'], $_POST['password']);
        header('Location: change_password.php?success');
    }
     else if (empty($errors) === false)
    {
        echo output_errors($errors);
    }
    /*  EXPLANATION - when you change password you don't loss a session because
    session is matched only by user_id after you log in*/
    ?>

    <form action="" method="post">
        <ul>
            <li>
                Current password*:
            </li>
            <li>
                <input type="password" name="current_password">
            </li>
            <li>
                New password*:
            </li>
            <li>
                <input type="password" name="password">
            </li>
            <li>
                Repeat new password*:
            </li>
            <li>
                <input type="password" name="password_again">
            </li>
            <li>
                <input type="submit" value="Change password">
            </li>
        </ul>
    </form>

    <?php
}
    include 'includes/overall/footer.php'
    ?>