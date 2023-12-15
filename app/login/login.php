<!doctype html>
<html lang="en">

<?php
require_once('../../lib/settings.php');

$currentScriptDirectory = dirname(__FILE__);
$rootDirectory = getRootDirectory();
$relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

require_once('../../lib/loginFunctions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            header("Location: ../dashboard/index.php");
            exit();
        } else {
            // Login failed
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        die("Login failed: " . $e->getMessage());
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