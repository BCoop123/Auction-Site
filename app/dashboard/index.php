<?php
require_once("../../lib/multipageFunctions.php");
require_once("../../themes/components/header_footer_import.php");
require_once('../../lib/settings.php');

// Function to display auction information in the desired format
function display_auction_info($auction) {
    global $relativePathToRoot;
    echo '<div class="col mb-5">';
    echo '<div class="card h-100">';
    echo '<img class="card-img-top" src="' . $relativePathToRoot . '/path/to/placeholder/image.jpg" alt="Auction Image" />'; // Use a placeholder image
    echo '<div class="card-body p-4">';
    echo '<div class="text-center">';
    echo '<h5 class="fw-bolder">' . $auction['title'] . '</h5>';
    echo '$' . $auction['highest_bid'];
    echo '</div>';
    echo '</div>';
    echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
    echo '<div class="text-center"><a class="btn btn-outline-dark mt-auto" href="' . $relativePathToRoot . '/app/dashboard/detail.php?id=' . $auction['auction_id'] . '">View options</a></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

$currentScriptDirectory = dirname(__FILE__);
$rootDirectory = getRootDirectory();
$relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

importHeader($relativePathToRoot);

// Function to save auction data to the database
function saveAuctionToDatabase($pdo, $title, $description, $startingBid, $startDate, $endDate) {
    try {
        // Start a transaction to ensure atomicity
        $pdo->beginTransaction();

        // Get user ID from the session
        $userId = $_SESSION['user_id'];

        // Prepare the SQL statement for auction insertion
        $stmtAuction = $pdo->prepare("INSERT INTO auction (owner_id, title, description, starting_bid, highest_bid, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Set highest_bid equal to starting_bid
        $highestBid = $startingBid;

        // Bind parameters for auction insertion
        $stmtAuction->bindParam(1, $userId);
        $stmtAuction->bindParam(2, $title);
        $stmtAuction->bindParam(3, $description);
        $stmtAuction->bindParam(4, $startingBid);
        $stmtAuction->bindParam(5, $highestBid);
        $stmtAuction->bindParam(6, $startDate);
        $stmtAuction->bindParam(7, $endDate);

        // Execute the auction insertion statement
        $stmtAuction->execute();

        // Get the last inserted auction_id
        $auctionId = $pdo->lastInsertId();

        // Prepare the SQL statement for auctionimagerelationship insertion
        $stmtAir = $pdo->prepare("INSERT INTO auctionimagerelationship (auction_id, image_id) VALUES (?, ?)");

        // Use a placeholder image_id for now; replace it with the actual image_id
        $imageId = 1;

        // Bind parameters for auctionimagerelationship insertion
        $stmtAir->bindParam(1, $auctionId);
        $stmtAir->bindParam(2, $imageId);

        // Execute the auctionimagerelationship insertion statement
        $stmtAir->execute();

        // Prepare the SQL statement for image insertion
        $stmtImage = $pdo->prepare("INSERT INTO image (image_name) VALUES (NULL)");

        // Execute the image insertion statement
        $stmtImage->execute();

        // Commit the transaction
        $pdo->commit();

        return true; // Indicate success

    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();

        // Handle any errors here
        echo "<div class='alert alert-danger mt-3'>Error saving auction to database: " . $e->getMessage() . "</div>";
        return false; // Indicate failure
    }
}

// Fetch auction data from the database
try {
    // SQL query to retrieve auction information with image details
    $query = '
        SELECT a.auction_id, a.title, a.highest_bid, i.image_name
        FROM auction AS a
        JOIN auctionimagerelationship AS air ON a.auction_id = air.auction_id
        JOIN image AS i ON air.image_id = i.image_id
    ';
    $stmt = $pdo->query($query);
} catch (PDOException $e) {
    // Handle query execution error
    echo "<div class='alert alert-danger mt-3'>Error executing query: " . $e->getMessage() . "</div>";
}

// Form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $startingBid = $_POST["startingBid"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Save form data to the database
    $auctionCreationResult = saveAuctionToDatabase($pdo, $title, $description, $startingBid, $startDate, $endDate);

    // Display success message if auction creation was successful
    if ($auctionCreationResult) {
        echo "<div class='alert alert-success mt-3'>Auction created successfully!</div>";
    }
}
?>

<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Traditional Auctions</h1>
        </div>
    </div>
</header>

<!-- Section-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-11">
            <section class="py-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                    // Output each auction row
                    while ($row = $stmt->fetch()) {
                        display_auction_info($row);
                    }
                    ?>
                </div>
            </section>

            <!-- Create Auction Form -->
            <div class="mt-5">
                <h2>Create Auction</h2>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="startingBid">Starting Bid:</label>
                        <input type="number" class="form-control" name="startingBid" id="startingBid" required>
                    </div>

                    <div class="form-group">
                        <label for="startDate">Start Date:</label>
                        <input type="datetime-local" class="form-control" name="startDate" id="startDate" required>
                    </div>

                    <div class="form-group">
                        <label for="endDate">End Date:</label>
                        <input type="datetime-local" class="form-control" name="endDate" id="endDate" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-top: 20px">Create Auction</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
<!-- Footer-->
<?php
importFooter($relativePathToRoot);
?>
