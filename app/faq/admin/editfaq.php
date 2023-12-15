<?php
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);

$faqFilePath = '../../../data/faq/faq.txt';

// Include the settings.php file
require_once("../../../lib/settings.php");

// Check if the form is submitted to save changes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newContent = $_POST["newContent"];

    // Update the FAQ content in the database
    try {
        // Prepare the SQL statement to update FAQ content in the database
        $stmt = $pdo->prepare("UPDATE faqsection SET response = :response WHERE question = :question");

        // Split the content into question and response
        list($question, $response) = explode("\n", $newContent, 2);

        // Bind parameters
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':response', $response);

        // Execute the statement
        $stmt->execute();
        
        header("Location: index.php"); // Redirect to the FAQ page
        exit();
    } catch (PDOException $e) {
        // Handle any errors here
        echo "<div class='alert alert-danger mt-3'>Error updating FAQ content: " . $e->getMessage() . "</div>";
    }
}

// Read the current FAQ content
$faqContent = file_get_contents($faqFilePath);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit FAQ</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit FAQ</h1>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="newContent">Edit FAQ Content:</label>
                <textarea class="form-control" name="newContent" id="newContent" rows="10"><?php echo $faqContent; ?></textarea>
            </div>

            <button type="submit" class="btn btn-success">Save Changes</button>
            <a href="index.php" class="btn btn-secondary">Go Back</a>
        </form>
    </div>

<!-- Footer-->
<?php
importFooter($pathToSurface);
?>

