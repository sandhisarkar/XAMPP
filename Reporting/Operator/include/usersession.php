
<?php

extract($_POST);

if (!isset($_SESSION[user]))
{
        echo "<br>You are not Logged In Please Login to Access this Page<br>";
        echo "<a href=../>Click Here to Login</a>";
        exit();
}

?>