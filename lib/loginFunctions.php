<?php
// Function to add a new user to the JSON file
function addNewUser($userInfo, $filePath) {
    $existingData = file_get_contents($filePath);
    $users = json_decode($existingData, true); // true for associative array
    $isNewUser = True;

    if (!is_array($users)) {
        $users = []; // Initialize as an empty array if the file is empty or invalid
    }



    foreach ($users as $user) {
        if ($userInfo[0] == $user["username"]) {
            $isNewUser = False;
        }
    };

    if ($isNewUser) {
        $newUser = [
            "username" => $userInfo[0],
            "password" => $userInfo[1],
            "firstName" => $userInfo[2],
            "lastName" => $userInfo[3],
            "email" => $userInfo[4],
            "address" => $userInfo[5],
            "city" => $userInfo[6],
            "state" => $userInfo[7],
            "zip" => $userInfo[8]
        ];
    
        $users[] = $newUser;
    
        $jsonContent = json_encode($users, JSON_PRETTY_PRINT);
        if (file_put_contents($filePath, $jsonContent) !== false) {
            initProfile($userInfo[0], "../../data/profile/profiles.json");
            login([$userInfo[0], $userInfo[1]], $filePath);
            return true; // Return true on success
        }
        return false; // Return false on failure
    }

    else {
        //echo "Username in use";
    }
    
}

function login($userInfo, $filePath) {
    $existingData = file_get_contents($filePath);
    $users = json_decode($existingData, true); // true for associative array

    if (!is_array($users)) {
        $users = []; // Initialize as an empty array if the file is empty or invalid
    }


    $isAuthenticated = false;
    foreach ($users as $user) {
        if ($userInfo[0] == $user["username"] && $userInfo[1] == $user["password"]) {
            $isAuthenticated = true;
            break; // exit loop once a match is found
        }
    }
    if ($isAuthenticated) {
        //session_start();
        $_SESSION["user_id"] = $user["username"];
        $_SESSION["permission"] = 0;
        return True;
    } else {
        //echo "incorrect credentials";
        return False;
    }
    
}

function initProfile($username, $filePath) {
    $existingData = file_get_contents($filePath);
    $profiles = json_decode($existingData, true); // true for associative array

    $newProfile = [
        "username" => $username,
        "profileIMG" => "/data/assets/account.png",
        "bio" => ""
    ];

    $profiles[] = $newProfile;

    $jsonContent = json_encode($profiles, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $jsonContent);
}

?>