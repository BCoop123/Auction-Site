<?php
$dir_path = "../../data/awards/awards.csv";
require_once('./awards.php');

// Check if the 'award' parameter is set in the URL
if (isset($_GET['award'])) {
    $awardName = $_GET['award'];
    $awardDetails = getAwardDetails($dir_path, $awardName);

    if (!$awardDetails) {
        echo "Award not found.";
        exit;
    }
} else {
    echo "No award specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $awardDetails[0]; ?> Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="text-center mt-4">
        <a href="edit.php?award=<?php echo urlencode($awardDetails[0]); ?>" class="btn btn-primary button-margin">Edit</a>
    </div>
    <div class="text-center mt-4">
        <a href="delete.php?award=<?php echo urlencode($awardDetails[0]); ?>" class="btn btn-primary button-margin">Delete</a>
    </div>
    <div class="container">
        <h1><?php echo $awardDetails[0]; ?> Details</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Award</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $awardDetails[0]; ?></td>
                    <td><?php echo $awardDetails[1]; ?></td>
                </tr>
            </tbody>
        </table>
        <a href="index.php">Back to Awards</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
