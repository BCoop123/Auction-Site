<?php

function getProfileImagePath($pathToSurface, $defaultImg = '../../data/assets/account.png') {
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
    return $defaultImg;
}

function populateSignAction(){
    if (isset($_COOKIE["username"])) {
        echo'
        '

    }
    else{

    }
}

?>