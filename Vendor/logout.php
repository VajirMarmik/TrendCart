<?php
include "db.php";

session_start();
session_destroy();
header("Location: index.php");
exit();
?>

<?php
// setcookie('email_username', '', time() - (60*60*24));
// setcookie('password', '', time() - (60*60*24));
?>
