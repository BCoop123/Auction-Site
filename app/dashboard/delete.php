<?php
require_once("../../lib/multipageFunctions.php");
require_once("../../themes/components/header_footer_import.php");
require_once('../../lib/settings.php');

// Logic that gets the relative path and root directory
$currentScriptDirectory = dirname(__FILE__);
$rootDirectory = getRootDirectory();
$relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

importHeader($relativePathToRoot);

// Check if the user is logged in and has a session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if auction_id is provided in the query parameters
if (!isset($_GET['id'])) {
    echo '<p>Auction ID not provided.</p>';
    importFooter($relativePathToRoot);
    exit();
}

$auctionId = $_GET['id'];

try {
    // Start a transaction to ensure atomicity
    $pdo->beginTransaction();

    // Delete the auction from the auction table
    $deleteAuctionQuery = 'DELETE FROM auction WHERE auction_id = :auctionId';
    $deleteAuctionStatement = $pdo->prepare($deleteAuctionQuery);
    $deleteAuctionStatement->bindParam(':auctionId', $auctionId, PDO::PARAM_INT);
    $deleteAuctionStatement->execute();

    // Commit the transaction
    $pdo->commit();

    // Display success message
    echo "<div class='alert alert-success mt-3'>Item successfully deleted.</div>";

} catch (PDOException $e) {
    // Rollback the transaction on error
    $pdo->rollBack();

    // Handle any errors here
    echo "<div class='alert alert-danger mt-3'>Error deleting auction: " . $e->getMessage() . "</div>";
}

// Footer
importFooter($relativePathToRoot);
?>
