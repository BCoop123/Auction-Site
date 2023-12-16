<?php
if (isset($_SESSION['username'])) {
    session_destroy()
}
header('Location: ../app/dashboard/index.php '); 
?>