<!doctype html>
<html lang="en">

<?php
require_once('../../lib/loginFunctions.php');
// Include database connection and path config
require_once('../../lib/settings.php');

// Logic that gets the realitive path and root directory
$currentScriptDirectory = dirname(__FILE__); // or __DIR__ in PHP 5.3 and later
$rootDirectory = getRootDirectory();
$relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $sql = "SELECT user_id, password FROM bidoramauser WHERE username = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);

        $credentials = $stmt->fetch();

        if (($credentials["user_id"]) && (password_verify($password, $credentials["password"]))) {
            // Login successful
            header("Location: ../dashboard/index.php");
        } else {
            // Login failed
            echo "Invalid username or password.";
        }
    } catch (e) {
        echo 'Failed to login';
    }
}

require_once("../../lib/multipageFunctions.php");
require_once("../../themes/components/header_footer_import.php");
$pathToSurface = "../..";

importTinyHeader($pathToSurface);
?>

<div class="login-signup-box">
    <!-- Login Form -->
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