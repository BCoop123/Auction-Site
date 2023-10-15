<?php
// Include necessary functions and variables
require_once('./landing.php');

// Define the path to the sections JSON file
$sectionsFile = "../../../data/landing/sections.json";

// Function to add a new section to the JSON file
function addNewSection($sectionsFile, $img, $title, $text) {
    $existingData = file_get_contents($sectionsFile);
    $sections = json_decode($existingData, true); // true for associative array

    if (!is_array($sections)) {
        $sections = []; // Initialize as an empty array if the file is empty or invalid
    }

    $newSection = [
        "img" => $img,
        "title" => $title,
        "text" => $text
    ];

    $sections[] = $newSection;

    $jsonContent = json_encode($sections, JSON_PRETTY_PRINT);
    if (file_put_contents($sectionsFile, $jsonContent) !== false) {
        return true; // Return true on success
    }
    return false; // Return false on failure
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $text = $_POST["text"];

    // If a file was uploaded, process it.
    if (isset($_FILES["img_upload"]) && $_FILES["img_upload"]["error"] == 0) {
        $imageExtension = pathinfo($_FILES["img_upload"]['name'], PATHINFO_EXTENSION);
        $randomNumber = mt_rand(100000, 999999); // Generate a random number for the filename
        $newFilename = $randomNumber . "." . $imageExtension;

        if ($_FILES["img_upload"]['size'] > 0 && strpos($_FILES["img_upload"]['type'], 'image/') === 0) {
            move_uploaded_file($_FILES["img_upload"]['tmp_name'], '../../../data/landing/img/' . $newFilename);
            $imgPath = "/data/landing/img/" . $newFilename;
        } else {
            echo "Invalid image type.";
            exit();
        }
    } else {
        echo "Error uploading image.";
        exit();
    }

    if (addNewSection($sectionsFile, $imgPath, $title, $text)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to add the section.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Section</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h1><?php echo isset($sectionToEdit) ? 'Edit Section' : 'Create New Section'; ?></h1>
        <form method="post" action="create.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="section_name">Section Title:</label>
                <input type="text" class="form-control" id="section_name" name="title" required
                    value="<?php echo isset($sectionToEdit) ? $sectionToEdit['title'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="section_description">Text:</label>
                <textarea class="form-control" id="section_description" name="text" rows="4"
                    required><?php echo isset($sectionToEdit) ? $sectionToEdit['text'] : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="img_upload">Upload Image:</label>
                <input type="file" class="form-control-file" id="img_upload" name="img_upload" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
