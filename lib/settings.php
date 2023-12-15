<?php
$host = '127.0.0.1';
$db = 'bidorama';
$user = 'root';
$pass = '';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

//Code from Jason

function getRootDirectory(){
    $projectName = 'Auction-Site'; // the name for the root folder, change if needed

    $dirExp = explode(DIRECTORY_SEPARATOR, __DIR__);
    array_unshift($dirExp, ''); // stops "undefined array key" error
    $rootPath = '';

    // parse file path and end it at the root directory folder name
    for ($i = 1; $i < count($dirExp); $i++) {
        if ($dirExp[$i - 1] != $projectName) {
            $rootPath = $rootPath . $dirExp[$i] . DIRECTORY_SEPARATOR;
        } else {
            break;
        }
    }

    return $rootPath;
}

function getRelativePathToRoot($currentScriptDirectory, $rootDirectory) {
    $currentScriptDirectory = realpath($currentScriptDirectory);
    $rootDirectory = realpath($rootDirectory);

    // Check if the paths are valid
    if (!$currentScriptDirectory || !$rootDirectory) {
        return false;
    }

    $relativePath = '';

    // Count the number of directories between the current script and the root directory
    $relativeLevels = substr_count($currentScriptDirectory, DIRECTORY_SEPARATOR) - substr_count($rootDirectory, DIRECTORY_SEPARATOR);

    // Append the appropriate number of '../' to the relative path
    for ($i = 0; $i < $relativeLevels; $i++) {
        $relativePath .= '..' . DIRECTORY_SEPARATOR;
    }

    return $relativePath;
}

// Example usage in your functions file
// $currentScriptDirectory = dirname(__FILE__); // or __DIR__ in PHP 5.3 and later
// $rootDirectory = getRootDirectory();

// $relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

?>