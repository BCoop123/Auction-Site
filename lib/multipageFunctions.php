<?php

function getProfileImagePath($filePath = '../../data/profile/profiles.json', $defaultImg = '../../data/profile/img/account.png') {
    // Check if username cookie is set
    if (isset($_COOKIE["username"])) {
        $username = $_COOKIE["username"];

        // Load profiles data
        $data = file_get_contents($filePath);
        $profiles = json_decode($data, true);

        foreach ($profiles as $profile) {
            if ($profile["username"] == $username) {
                return $profile["profileIMG"];
            }
        }
    }

    // Return default image path if profile or image not found
    return $defaultImg;
}

?>