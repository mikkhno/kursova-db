<!-- ЗАВЕРШЕННЯ КОРИСТУВАЦЬКОГО СЕАНСУ -->
<?php
session_start();
$_SESSION["Username"] = "";
session_destroy();
header("Location:login_page.html");
?>