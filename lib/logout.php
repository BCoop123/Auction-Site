<?php
if (isset($_COOKIE['username'])) {
    unset($_COOKIE['username']);
    setcookie('username', '', time() - 3600, '/'); // Delete the 'username' cookie
}
header('Location: ../app/dashboard/index.php '); 
?>