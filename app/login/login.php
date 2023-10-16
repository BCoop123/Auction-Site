<!doctype html>
<html lang="en">

<?php
require_once('../../lib/loginFunctions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userInfo = [
        $_POST["username"],
        $_POST["password"],
    ];


    if (login($userInfo, "../../data/users/users.json")) {
        header("Location: ../dashboard/index.php");
        exit();
    } else {
        //echo "Failed to sign in.";
    }
}

require_once("../../lib/multipageFunctions.php");
require_once("../../themes/components/header_footer_import.php");
$pathToSurface = "../..";

importTinyHeader($pathToSurface);

?>
    <div class="login-signup-box">
        <!-- Signup Form -->
        <form class="row g-3" method="post">
            <div class="col-12">
                <label class="form-label" for="autoSizingInputGroup">Username</label>
                <div class="input-group">
                    <div class="input-group-text">@</div>
                    <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Username" name="username">
                </div>
            </div>
            <div class="col-md-12">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword4" name="password">
            </div>
            <div class="col-6 switch-link d-flex">
                <a href="./signup.php" onclick="showForm('signup')" style="text-decoration: none;">Sign up instead</a>
            </div>
            <div class="col-6">
                <button class="btn btn-primary w-100 mb-3" type="submit">Login</button>
            </div>
        </form>
    </div>

<!-- Footer-->
<?php
    importTinyFooter($pathToSurface);
?> 