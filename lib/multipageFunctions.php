<?php
//initilize the session
session_start();

function getProfileImagePath($pathToSurface) {
    // Include database connection and path config
    require_once($pathToSurface . '/lib/db.php');

    // Check if username cookie is set
    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];

        $sql = "SELECT image_name
                FROM image i
                JOIN bidoramauser b
                ON i.image_id = b.image_id
                WHERE user_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);

        $result = $stmt->fetch();

        if ($result) {
            return $pathToSurface . "\data\profile\img\\" . $result["image_name"];
        }
        else {
            $result = "1.png";
            return $pathToSurface . "\data\profile\img\\" . $result;
        }
        

    }

    else {
        $result = "1.png";
        return $pathToSurface . $result;
    }

    // Return default image path if profile or image not found
    //return $pathToSurface . $result;
}

function getProfileLink($pathToSurface){
    if (isset($_SESSION["user_id"])) {
        
        return $pathToSurface . "/app/profile/index.php";

    
    }else {
        return $pathToSurface . "/app/login/login.php";
 
    }

}

function populateSignActionNav($pathToSurface){
    if (isset($_COOKIE["username"])) {
        return '<form action="' . $pathToSurface . '/lib/logout.php" method="post" style="margin: 0; padding: 0;"><button type="submit" class="custom-btn sign-out-button">Sign Out</button></form>';    
    }
    else {
        return '<a href="' . $pathToSurface . '/app/login/login.php"><div class="custom-btn">Sign In / Sign Up</div></a>';

    }
}
function goToAccount($pathToSurface){
    if (isset($_SESSION["user_id"])) {
        return '<a href="' . $pathToSurface . '/app/profile/index.php"><div class="custom-btn">Account Details</div></a>';
    }
    else {
        return '<a href="' . $pathToSurface . '/app/login/login.php"><div class="custom-btn">Account Details</div></a>';

    }
}

function getUserName(){
    if (isset($_SESSION["user_id"])) {
        $username = $_SESSION["user_id"];
        return $username;
    }
    else {
        return 'Sign In / Sign Up';

    }

}
?>