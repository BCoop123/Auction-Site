<?php
require_once("../../lib/multipageFunctions.php");
require_once("../../themes/components/header_footer_import.php");
require_once('../../lib/settings.php');

// Logic that gets the relative path and root directory
$currentScriptDirectory = dirname(__FILE__);
$rootDirectory = getRootDirectory();
$relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

importHeader($relativePathToRoot);

// Get the auction ID from the query parameter
$auctionId = isset($_GET['id']) ? $_GET['id'] : null;

// Fetch auction details for editing
$query = 'SELECT owner_id, title, description, highest_bid, start_date, end_date, i.image_name
          FROM auction AS a
          JOIN auctionimagerelationship AS air ON a.auction_id = air.auction_id
          JOIN image AS i ON air.image_id = i.image_id
          WHERE a.auction_id = :auctionId';
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

// Display the auction information for editing
if ($auctionDetails && $isOwner) {
    echo '<div class="container">';
    echo '<div class="row justify-content-center">';
    echo '<div class="col-8">';
    echo '<form method="post" action="update.php">';
    echo '<input type="hidden" name="auction_id" value="' . $auctionId . '">'; // Include auction ID as a hidden field for identification during update

    echo '<div class="form-group">';
    echo '<label for="title">Title:</label>';
    echo '<input type="text" class="form-control" name="title" id="title" value="' . $auctionDetails['title'] . '" required>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="description">Description:</label>';
    echo '<textarea class="form-control" name="description" id="description" rows="4" required>' . $auctionDetails['description'] . '</textarea>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="highestBid">Starting Bid:</label>';
    echo '<input type="number" class="form-control" name="startingBid" id="startingBid" value="' . $auctionDetails['highest_bid'] . '" required>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="startDate">Start Date:</label>';
    echo '<input type="datetime-local" class="form-control" name="startDate" id="startDate" value="' . date('Y-m-d\TH:i', strtotime($auctionDetails['start_date'])) . '" required>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="endDate">End Date:</label>';
    echo '<input type="datetime-local" class="form-control" name="endDate" id="endDate" value="' . date('Y-m-d\TH:i', strtotime($auctionDetails['end_date'])) . '" required>';
    echo '</div>';

    echo '<button type="submit" class="btn btn-primary">Update Auction</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
} else {
    echo '<p>Auction not found or you do not have permission to edit.</p>';
}

// Footer
importFooter($relativePathToRoot);
?>
