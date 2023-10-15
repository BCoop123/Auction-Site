<?php
// Include necessary functions
require_once('./landing.php');

$message = "";
$pathToRoot =  "../../..";

// Check if the 'name' parameter is set in the URL
if (isset($_GET['name'])) {
    $sectionName = $_GET['name'];

    $sectionDetails = getSectionDetails($sectionName);
    $imgPath = $sectionDetails['img'];

    // Check if the form is submitted to delete the section
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
        if (deleteSection($sectionName)) {
            // Delete the associated image
            if (file_exists($pathToRoot . $imgPath) && is_writable($pathToRoot . $imgPath)) {
                unlink($pathToRoot . $imgPath);
            }
            header("Location: index.php?message=deleted");
            exit();
        } else {
            $message = "Failed to delete the section.";
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Section</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1>Confirm Deletion</h1>
        <p>Are you sure you want to delete this section?</p>
        
        <?php
        if ($message) {
            echo "<div class='alert alert-danger'>$message</div>";
        }
        ?>

        <form method="post" action="delete.php?name=<?= urlencode($sectionName) ?>">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>