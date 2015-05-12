<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/header.php';

if(isset($_GET['success']) === true)
{
?>
    <h2>Thanks, we have activated your account...</h2>
    <p>Your are free to log in</p>
<?php

}
if(isset($_GET['e_mail'] ) === true)//, $_GET['e_mail_code']
{
    $email      = trim($_GET["e_mail"]);         //ADD SECURTY: trim remove any whitespaces "copy-paste"
    $email_code = trim($_GET['e_mail_code']);

    //$email          = "josip-matic@hotmail.com";
    //$email_code     = "7bd48fd08df08799b66755ccad3514b9";
    echo $email.'<br>';
    echo $email_code.'<br>';

    //sleep(3);

    if(email_exists($email) === false)
    {
        $errors[] = "Oops, something went wrong, and we couldn't find that email address!";
    }
    /*PROVJERITI ACTIVATE!!!*/
    else if (activate($email, $email_code) === false)
    {
        $errors[] = "We had problems activating your account";
    }

    if(empty($errors) === false)
    {
?>
        <h2>Oops...</h2>
<?php
        echo output_errors($errors);
    }
    else
    {
        header('Location: activate.php?success');
    }
}
else
{
    sleep(3);   //wait 5 seconds
    header('Location: index.php');
    exit();
}

include 'includes/overall/footer.php' ?>