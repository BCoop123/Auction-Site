<?php
if (isset($_POST["saveChanges"])) {
    // Check if the "Save Changes" button is clicked
    $aboutText = $_POST["aboutText"];
    
    // Write the updated content to the "about.txt" file
    $file = fopen("../../../data/about/about.txt", "w");
    if ($file) {
        fwrite($file, $aboutText);
        fclose($file);
        // Redirect back to the editabout.php page after saving
        header("Location: editabout.php");
        exit();
    } else {
        // Handle file write error (e.g., display an error message)
        echo "Error writing to the file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Edit About Us - Auction Site" />
    <meta name="author" content="Ben A, Ben M, Logan, Brandon" />
    <title>Edit About Us - Auction Site</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
</head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Start Bootstrap</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="../../dashboard">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="editabout.php">Edit About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Edit About Page Content-->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bolder">Edit About Our Auction Site</h2>
                    <form action="editabout.php" method="post">
                        <div class="form-group">
                            <label for="aboutText">About Text</label>
                            <textarea class="form-control" id="aboutText" name="aboutText" rows="10">
                                <?php
                                    // Read content from data/about.txt and display it in the textarea
                                    $aboutText = file_get_contents("../../../data/about/about.txt");
                                    echo $aboutText;
                                ?>
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="saveChanges">Save Changes</button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <img class="img-fluid rounded" src="https://dummyimage.com/600x400/dee2e6/6c757d.jpg" alt="About Us Image" />
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <!-- ... (footer code) ... -->
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
</body>
</html>
