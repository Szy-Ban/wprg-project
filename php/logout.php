<?php
session_start();

if (isset($_SESSION['login_user'])) {
    unset($_SESSION['login_user']); //usuniecie sesji
}

header("Location: index.php"); //przeniesienie
exit();
?>