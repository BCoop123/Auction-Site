<?php
require_once("../../lib/multipageFunctions.php");
require_once("../../themes/components/header_footer_import.php");
require_once('../../lib/settings.php');

// Logic that gets the relative path and root directory
$currentScriptDirectory = dirname(__FILE__);
$rootDirectory = getRootDirectory();
$relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

importHeader($relativePathToRoot);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get auction ID from the form
    $auctionId = isset($_POST['auction_id']) ? $_POST['auction_id'] : null;

    // Fetch auction details for updating
    $query = 'SELECT owner_id, title, description, highest_bid, start_date, end_date
              FROM auction
              WHERE auction_id = :auctionId';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':auctionId', $auctionId, PDO::PARAM_INT);
    $statement->execute();

    // Fetch the auction details
    $auctionDetails = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if the user is the owner of the auction
    $isOwner = false;
    if ($auctionDetails && isset($_SESSION['user_id'])) {
        $isOwner = ($_SESSION['user_id'] == $auctionDetails['owner_id']);
    }

    // Update the auction details in the database
    if ($auctionDetails && $isOwner) {
        try {
            // Start a transaction to ensure atomicity
            $pdo->beginTransaction();

            // Update auction details
            $updateQuery = 'UPDATE auction
                            SET title = :title,
                                description = :description,
                                highest_bid = :startingBid,
                                start_date = :startDate,
                                end_date = :endDate
                            WHERE auction_id = :auctionId';
            $updateStatement = $pdo->prepare($updateQuery);

            $updateStatement->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
            $updateStatement->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
            $updateStatement->bindParam(':startingBid', $_POST['startingBid'], PDO::PARAM_INT);
            $updateStatement->bindParam(':startDate', $_POST['startDate'], PDO::PARAM_STR);
            $updateStatement->bindParam(':endDate', $_POST['endDate'], PDO::PARAM_STR);
            $updateStatement->bindParam(':auctionId', $auctionId, PDO::PARAM_INT);

            $updateStatement->execute();

            // Commit the transaction
            $pdo->commit();

            // Display success message
            echo '<div class="alert alert-success mt-3">Item successfully edited.</div>';
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $pdo->rollBack();

            // Handle any errors here
            echo '<div class="alert alert-danger mt-3">Error updating auction details: ' . $e->getMessage() . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger mt-3">Auction not found or you do not have permission to edit.</div>';
    }
} else {
    // If the form is not submitted, display an error
    echo '<div class="alert alert-danger mt-3">Invalid request.</div>';
}

// Footer
importFooter($relativePathToRoot);
?>
