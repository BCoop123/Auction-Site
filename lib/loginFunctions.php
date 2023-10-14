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


    foreach ($users as $user) {
        if ($userInfo[0] == $user["username"] and $userInfo[1]) {
            $isNewUser = False;
        }
    };
}

?>