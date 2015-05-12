<?php
include 'core/init.php';
include 'includes/overall/header.php'
?>
    <h1>Test get</h1>
<?php
//try this "http://localhost/template/testget.php?nesto=tebeTrazim&josnesto=maLazemTi"
if(isset($_GET['e_mail'], $_GET['e_mail_code']) === true)
{
    echo $_GET['e_mail'].'<br>';
    echo $_GET['e_mail_code'];
    //use this "http://localhost/template/testget.php?e_mail=josip-matic@hotmail.com&e_mail_code=7bd48fd08df08799b66755ccad3514b9"
}


include 'includes/overall/footer.php' ?>