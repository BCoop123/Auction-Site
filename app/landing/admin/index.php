<?php
$dir_path = "../../data/awards";
$headings = ["Award", "Description"];
require_once('./awards.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awards</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .button-margin {
            margin-bottom: 0.5in;
        }
    </style>
</head>

<body>

    <div class="text-center mt-4">
        <a href="create.php" class="btn btn-primary button-margin">Create New</a>
    </div>

    <?php
    createTable($headings, getAwardInfo($dir_path))
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
