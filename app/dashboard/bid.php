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

// Fetch the auction details from the database
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

// Display the auction information
if ($auctionDetails) {
    echo '<div class="container">';
    echo '<div class="row justify-content-center">';
    echo '<div class="col-8">';
    echo '<div class="card">';
    echo '<img class="card-img-top" src="' . $relativePathToRoot . '/path/to/your/image/folder/' . $auctionDetails['image_name'] . '" alt="Auction Image" />';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $auctionDetails['title'] . '</h5>';
    echo '<p class="card-text">' . $auctionDetails['description'] . '</p>';
    echo '<p class="card-text">Current Bid: $' . $auctionDetails['highest_bid'] . '</p>';
    echo '<p class="card-text">Start Date: ' . $auctionDetails['start_date'] . '</p>';
    echo '<p class="card-text">End Date: ' . $auctionDetails['end_date'] . '</p>';

    // Display edit, delete, and place bid buttons if the user is the owner
    if ($isOwner) {
        echo '<a href="edit.php?id=' . $auctionId . '" class="btn btn-primary">Edit</a>';
        echo '<a href="delete.php?id=' . $auctionId . '" class="btn btn-danger">Delete</a>';
    }

    // Bid form
    echo '<form method="post" action="process_bid.php?id=' . $auctionId . '">';
    echo '<div class="form-group">';
    echo '<label for="bidAmount">Enter Bid Amount:</label>';
    echo '<input type="number" class="form-control" name="bidAmount" id="bidAmount" required>';
    echo '</div>';
    echo '<button type="submit" class="btn btn-success">Submit Bid</button>';
    echo '</form>';

    // Add more details as needed
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

} else {
    echo '<p>Auction not found.</p>';
}

// Footer
importFooter($relativePathToRoot);
?>
