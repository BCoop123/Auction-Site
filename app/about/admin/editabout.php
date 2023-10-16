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

require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);
?>
    <!-- Edit About Page Content-->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bolder">Edit About Our Auction Site</h2>
                    <form action="editabout.php" method="post">
                        <div class="form-group">
                            <label for="aboutText">About Text</label>
                            <textarea class="form-control" id="aboutText" name="aboutText" rows="10"><?php
                                // Read content from data/about.txt and display it in the textarea
                                $aboutText = file_get_contents("../../../data/about/about.txt");
                                echo $aboutText;
                            ?></textarea>
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

<?php
    importFooter($pathToSurface);
?> 
