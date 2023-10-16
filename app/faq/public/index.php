<?php
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);
?>

    <div class="container">
        <h1 class="mt-5">Frequently Asked Questions (FAQ)</h1>

        <!-- Display FAQ content in a box -->
        <div class="alert alert-info" style="background-color: #ffc907; border-color: black; color: black">
            <?php
            // Read FAQ content from the file
            $faqFilePath = '../../../data/faq/faq.txt';
            if (file_exists($faqFilePath)) {
                $faqContent = file_get_contents($faqFilePath);
                echo nl2br($faqContent); // Preserve line breaks
            } else {
                echo "FAQ content not available.";
            }
            ?>
        </div>

        <a href="contact.php" class="btn btn-primary" style="margin-bottom: 10px;">Contact Us</a>
    </div>



<!-- Footer-->
<?php
importFooter($pathToSurface);
?> 
