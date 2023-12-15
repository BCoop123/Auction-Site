<?php
// Include necessary functions and variables
require_once('./landing.php');
require_once('../public/landingFunctions.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["text"];

    // If a file was uploaded, process it.
    if (isset($_FILES["img_upload"]) && $_FILES["img_upload"]["error"] == 0) {
        $imageExtension = pathinfo($_FILES["img_upload"]['name'], PATHINFO_EXTENSION);
        $randomNumber = mt_rand(100000, 999999); // Generate a random number for the filename
        $newFilename = $randomNumber . "." . $imageExtension;

        if ($_FILES["img_upload"]['size'] > 0 && strpos($_FILES["img_upload"]['type'], 'image/') === 0) {
            move_uploaded_file($_FILES["img_upload"]['tmp_name'], '../../../data/landing/img/' . $newFilename);
            $image_name = $newFilename;
        } else {
            echo "Invalid image type.";
            exit();
        }
    } else {
        echo "Error uploading image.";
        exit();
    }

    try {
        $landing_section_id = LandingSections::createLandingSection($image_name, $title, $content);
        header("Location: index.php?" . $landing_section_id);
        exit();
    }
    catch(e) {
        echo "Failed to add the section.";
    }
}

//stuff for header
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);

?>

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

<?php
    importFooter($pathToSurface);
?>