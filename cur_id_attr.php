<!-- AJAX і HTML у MAIN.PHP  -->
<?php
session_start();
if (isset($_GET['cur_id'])) {
    $_SESSION['cur_id'] = $_GET['cur_id'];
}
?>