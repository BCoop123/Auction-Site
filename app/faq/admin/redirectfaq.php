<?php
// redirect.php

require_once("../../../lib/settings.php");


// Include the settings.php file
require_once("../../../lib/settings.php");

// Check if the form is submitted to save changes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newQuestion = $_POST["newQuestion"];
    $newResponse = $_POST["newResponse"];

    // Update the FAQ content in the database
    try {
        // Prepare the SQL statement to update FAQ content in the database
        $stmt = $pdo->prepare("INSERT INTO faqsection (question, response) VALUES (:question, :response)");

        // Bind parameters
        $stmt->bindParam(':question', $newQuestion);
        $stmt->bindParam(':response', $newResponse);

        // Execute the statement
        $stmt->execute();

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        // Handle any errors here
        echo "<div class='alert alert-danger mt-3'>Error updating FAQ content: " . $e->getMessage() . "</div>";
    }
}
?>
