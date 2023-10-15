<?php
function readJsonData($filePath) {
    // Check if the file exists
    if (!file_exists($filePath)) {
        return null; // File not found
    }

    // Read the JSON file and decode it
    $jsonContents = file_get_contents($filePath);
    $jsonData = json_decode($jsonContents, true);

    // Check if JSON decoding was successful
    if ($jsonData === null) {
        return null; // JSON parsing error
    }

    return $jsonData;
}
?>
