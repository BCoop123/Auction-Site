<?php
$pathToSurface = "../../..";
include_once($pathToSurface . "/lib/multipageFunctions.php");
include_once($pathToSurface . "/themes/components/header_footer_import.php");

importHeader($pathToSurface);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="About Us - Auction Site" />
    <meta name="author" content="Ben A, Ben M, Logan, Brandon" />
    <title>About Us - Auction Site</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
    <!-- About Page Content-->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bolder">About Our Auction Site</h2>
                    <p class="lead">
                        <?php
                            // Read content from data/about.txt and display it in the paragraph
                            $aboutText = file_get_contents("../../../data/about/about.txt");
                            echo $aboutText;
                        ?>
                    </p>
                </div>
                <div class="col-lg-6">
                    <img class="img-fluid rounded" src="https://dummyimage.com/600x400/dee2e6/6c757d.jpg" alt="About Us Image" />
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <?php
    importFooter($pathToSurface);
    ?> 

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
</body>
</html>