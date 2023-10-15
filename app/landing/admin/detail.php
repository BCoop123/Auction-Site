<?php
require_once('./landing.php');

// Check if the 'name' parameter is set in the URL
if (isset($_GET['name'])) {
    $sectionName = $_GET['name'];
    $sectionInfo = getSectionDetails($sectionName);

    if (!$sectionInfo) {
        echo "Section not found.";
        exit;
    }
} else {
    echo "No section specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $sectionName; ?> Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="text-center mt-4">
        <a href="edit.php?name=<?= urlencode($sectionName) ?>" class="btn btn-primary button-margin">Edit</a>
    </div>
    <div class="text-center mt-4">
        <!-- Assuming you will use 'name' to identify the section for deletion too -->
        <a href="delete.php?name=<?= urlencode($sectionName) ?>" class="btn btn-danger button-margin">Delete</a>
    </div>
    <div class="container">
        <h1><?php echo $sectionName; ?> Details</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Text</th>
                    <th>IMG</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $sectionInfo['title']; ?></td>
                    <td><?php echo $sectionInfo['text']; ?></td>
                    <td><?php echo $sectionInfo['img']; ?></td>
                </tr>
            </tbody>
        </table>
        <a href="index.php">Back to Sections</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
