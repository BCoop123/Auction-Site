<!doctype html>
<html lang="en">

<?php

require_once('../../lib/loginFunctions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userInfo = [
        $_POST["username"],
        $_POST["password"],
        $_POST["firstName"],
        $_POST["lastName"],
        $_POST["email"],
        $_POST["address"],
        $_POST["city"],
        $_POST["state"],
        $_POST["zip"]
    ];


    if (addNewUser($userInfo, "../../data/users/users.json")) {
        header("Location: ../dashboard/index.php");
        exit();
    } else {
        //echo "Failed to add the user.";
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login/Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
        }

        .login-signup-box {
            width: 600px; /* increased width */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .switch-link {
            text-align: right;
            color: blue; /* kept blue color */
            text-decoration: none; /* removed underline */
        }
    </style>
</head>

<body>
    <div class="login-signup-box">
        <!-- Signup Form -->
        <form class="row g-3" method="post">
            <div class="col-auto">
                <label class="form-label" for="autoSizingInputGroup">Username</label>
                <div class="input-group">
                    <div class="input-group-text">@</div>
                    <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Username" name="username">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword4" name="password">
            </div>
            <div class="col-md-6">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" name="firstName">
            </div>
            <div class="col-md-6">
                <label for="lasnName" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lastName">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail4" name="email">
            </div>

            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity" name="city">
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" class="form-select" name="state">
                <option selected>Choose...</option>
                <option>...</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Zip</label>
                <input type="text" class="form-control" id="inputZip" name="zip">
            </div>
            <div class="col-6 switch-link d-flex">
                <a href="./login.php" onclick="showForm('signup')">Login instead</a>
            </div>
            <div class="col-6">
                <button class="btn btn-primary w-100 mb-3" type="submit">Signup</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
