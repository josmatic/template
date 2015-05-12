<?php
function logged_in_redirect()
{
    if(logged_in() === true)
    {
        header('Location: index.php');
        exit();
    }
}
function protected_page()
{
    if(logged_in() === false)
    {
        header('Location: protected.php');
        exit();
    }
}
function array_sanitize(&$item) //send $item by reference
{
    $item = mysql_real_escape_string($item);
}
function sanitize($data)
{
    return mysql_real_escape_string($data); // Escapes special characters in a string for use in an SQL statement
}
function output_errors($errors) //enter only one and echo array
{
    return '<ul><li>'.implode('</li><li>', $errors).'</li></ul>';
}
/*
 * EXPLAINATION
It's a common misconception that user input can be filtered. PHP even has a (now deprecated) "feature", called
 magic-quotes, that builds on this idea. It's nonsense. Forget about filtering (Or cleaning, or whatever people call it).

What you should do, to avoid problems is quite simple: Whenever you embed a string within foreign code, you must escape
it, according to the rules of that language. For example, if you embed a string in some SQL targeting MySql, you must
escape the string with MySql's function for this purpose (mysqli_real_escape_string).

Another example is HTML: If you embed strings within HTML markup, you must escape it with htmlspecialchars. This means
that every single echo or print statement should use htmlspecialchars.

A third example could be shell commands: If you are going to embed strings (Such as arguments) to external commands,
and call them with exec, then you must use escapeshellcmd and escapeshellarg.

And so on and so forth ...

The only case where you need to actively filter data, is if you're accepting preformatted input. Eg. if you let your
users post HTML markup, that you plan to display on the site. However, you should be wise to avoid this at all cost,
since no matter how well you filter it, it will always be a potential security hole.
*/
?>