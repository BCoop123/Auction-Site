<?php
session_destroy();
foreach ($_COOKIE as $cookieName => $cookieValue) {
    setcookie($cookieName, '', time() - 3600, '/');
}
header('Location: ../app/dashboard/index.php?status=logout'); 
?>