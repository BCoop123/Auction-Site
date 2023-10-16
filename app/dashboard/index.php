<?php
include_once("../../lib/multipageFunctions.php");
include_once("../../themes/components/header_footer_import.php");
$pathToSurface = "../..";

importHeader($pathToSurface);

// Load product data from the JSON file
$jsonData = file_get_contents('../../data/auctions/auctions.json');
$data = json_decode($jsonData, true);

// Function to display product information in the desired format
function display_product_info($product) {
    echo '<div class="col mb-5">';
    echo '<div class="card h-100">';
    echo '<img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />';
    echo '<div class="card-body p-4">';
    echo '<div class="text-center">';
    echo '<h5 class="fw-bolder">' . $product['name'] . '</h5>';
    echo '$' . $product['price'];
    echo '</div>';
    echo '</div>';
    echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
    echo '<div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}


?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <?php
                echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
                foreach ($data['products'] as $product) {
                    display_product_info($product);
                }
                echo '</div>';
            ?>
        </section>
        <!-- Footer-->
        <?php
        importFooter($pathToSurface);
        ?> 
    </body>
</html>
