<?php

function getProfileImagePath($pathToSurface, $defaultImg = '/data/assets/account.png') {
    $filePath = $pathToSurface . "/data/profile/profiles.json";

    // Check if username cookie is set
    if (isset($_COOKIE["username"])) {
        $username = $_COOKIE["username"];

        // Load profiles data
        $data = file_get_contents($filePath);
        $profiles = json_decode($data, true);

        foreach ($profiles as $profile) {
            if ($profile["username"] == $username) {
                return $pathToSurface . $profile["profileIMG"];
            }
        }
    }

    // Return default image path if profile or image not found
    return $pathToSurface . $defaultImg;
}

function getProfileLink($pathToSurface){
    if (isset($_COOKIE["username"])) {
        
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
    if (isset($_COOKIE["username"])) {
        return '<a href="' . $pathToSurface . '/app/profile/index.php"><div class="custom-btn">Account Details</div></a>';
    }
    else {
        return '<a href="' . $pathToSurface . '/app/login/login.php"><div class="custom-btn">Account Details</div></a>';

    }
}
?>