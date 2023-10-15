<?php
// Include necessary functions and variables
require_once('./awards.php');

// Define the path to the awards CSV file
$awardsFile = "../../data/awards/awards.csv";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $awardName = $_POST["award_name"];
    $awardDescription = $_POST["award_description"];
    // Add the new award to the CSV file
    if (addNewAward($awardsFile, $awardName, $awardDescription)) {
        // Redirect to the edit page for the newly created award
        header("Location: edit.php?file=" . urlencode($awardName));
        exit();
    } else {
        echo "Failed to add the award to the database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Award</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h1>Create New Award</h1>
        <form method="post" action="create.php">
            <div class="form-group">
                <label for="award_name">Award Name:</label>
                <input type="text" class="form-control" id="award_name" name="award_name" required>
            </div>
            <div class="form-group">
                <label for="award_description">Award Description:</label>
                <textarea class="form-control" id="award_description" name="award_description" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
