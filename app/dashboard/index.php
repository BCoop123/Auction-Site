<?php
require_once("../../lib/multipageFunctions.php");
require_once("../../themes/components/header_footer_import.php");

// Include database connection and path config
require_once('../../lib/settings.php');

// Logic that gets the relative path and root directory
$currentScriptDirectory = dirname(__FILE__); // or __DIR__ in PHP 5.3 and later
$rootDirectory = getRootDirectory();
$relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

importHeader($relativePathToRoot);

// SQL query to retrieve auction information with image details
$query = '
    SELECT a.auction_id, a.title, a.highest_bid, i.image_name
    FROM auction AS a
    JOIN auctionimagerelationship AS air ON a.auction_id = air.auction_id
    JOIN image AS i ON air.image_id = i.image_id
';
$statement = $pdo->query($query);

// Function to display auction information in the desired format
function display_auction_info($auction) {
    global $relativePathToRoot;
    echo '<div class="col mb-5">';
    echo '<div class="card h-100">';
    echo '<img class="card-img-top" src="' . $relativePathToRoot . '/path/to/your/image/folder/' . $auction['image_name'] . '" alt="Auction Image" />';
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
<div class="container"> <!-- Adding a container for the grid system -->
    <div class="row justify-content-center"> <!-- This row centers the col-10 content -->
        <div class="col-11">
            <section class="py-5">
                <?php
                echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    display_auction_info($row);
                }
                echo '</div>';
                ?>
            </section>
        </div>
    </div>
</div>
<!-- Footer-->
<?php
importFooter($relativePathToRoot);
?>
