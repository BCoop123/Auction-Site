<?php
require_once("../../../lib/settings.php");  // Include the settings.php file

// Check if the contact ID is provided in the URL
if (isset($_GET['id'])) {
    $contactId = (int)$_GET['id'];

    try {
        // Prepare the SQL statement to delete the contact entry from the database
        $stmt = $pdo->prepare("DELETE FROM contactsection WHERE contact_id = :id");
        $stmt->bindParam(':id', $contactId, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the contact list (index.php) after deletion
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors here
        echo "<div class='alert alert-danger mt-3'>Error deleting contact entry: " . $e->getMessage() . "</div>";
        exit();
    }
} else {
    // If the contact ID is not provided in the URL, display an error message
    echo "<div class='alert alert-danger mt-3'>Invalid contact ID.</div>";
    exit();
}
?>

