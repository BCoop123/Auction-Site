<?php
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);

$faqFilePath = '../../../data/faq/faq.txt';

// Check if the form is submitted to save changes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newContent = $_POST["newContent"];
    // Save the edited content to the FAQ file
    file_put_contents($faqFilePath, $newContent);
    header("Location: index.php"); // Redirect to the FAQ page
    exit();
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
