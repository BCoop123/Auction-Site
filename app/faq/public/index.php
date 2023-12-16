<?php
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
require_once("../../../lib/settings.php");  // Include the settings.php file

$pathToSurface = "../../..";

importHeader($pathToSurface);

function getFAQContent($pdo) {
    try {
        // Prepare the SQL statement to retrieve FAQ questions and responses from the database
        $stmt = $pdo->prepare("SELECT question, response FROM faqsection");
        $stmt->execute();

        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if content is available
        if ($results) {
            $content = '';
            foreach ($results as $result) {
                $content .= '<strong>' . htmlspecialchars($result['question']) . '</strong><br>';
                $content .= nl2br(htmlspecialchars($result['response'])) . '<br><br>';
            }
            return $content;
        } else {
            return "FAQ content not available.";
        }
    } catch (PDOException $e) {
        // Handle any errors here
        return "Error retrieving FAQ content: " . $e->getMessage();
    }
}

?>

<div class="container">
    <h1 class="mt-5">Frequently Asked Questions (FAQ)</h1>

    <!-- Display FAQ content in a box -->
    <div class="alert alert-info" style="background-color: #ffc907; border-color: black; color: black">
        <?php
        // Get FAQ content from the database
        echo getFAQContent($pdo);
        ?>
    </div>

    <a href="contact.php" class="btn btn-primary" style="margin-bottom: 20px;">Contact Us</a>
</div>

<!-- Footer-->
<?php
importFooter($pathToSurface);
?>

