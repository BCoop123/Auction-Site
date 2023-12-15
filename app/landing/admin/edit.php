<?php
require_once('./landing.php');
require_once('../public/landingFunctions.php');

// Assuming you have the section_id available from your form or URL parameter
$section_id = $_GET["id"];

// Use the readLandingSection function to retrieve the section data
$sectionToEdit = LandingSections::readLandingSection($section_id);
$pathToRoot = "../../..";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $originalId = $_GET["id"];
    $newName = $_POST["title"];
    $content = $_POST["text"];
    $newFilename = "";

    // Check if a new image file was uploaded
    if (isset($_FILES["img_upload"]) && $_FILES["img_upload"]["error"] == 0) {
        $imageExtension = pathinfo($_FILES["img_upload"]['name'], PATHINFO_EXTENSION);
        $randomNumber = mt_rand(100000, 999999);
        $newFilename = $randomNumber . "." . $imageExtension;

        if ($_FILES["img_upload"]['size'] > 0 && strpos($_FILES["img_upload"]['type'], 'image/') === 0) {
            move_uploaded_file($_FILES["img_upload"]['tmp_name'], '../../../data/landing/img/' . $newFilename);
            $imgPath = "/data/landing/img/" . $newFilename;

            // Remove the old image file if it exists
            $oldImgPath = $sectionToEdit->getImage();
            if (file_exists($oldImgPath) && is_writable($oldImgPath)) {
                unlink($oldImgPath);
            }
        } else {
            echo "Invalid image type.";
            exit();
        }
    } else {
        // Keep the existing image path if no new image was uploaded
        $imgPath = $sectionToEdit->getImage();
    }

    if (LandingSections::editLandingSection($originalId, $newName, $content, $newFilename)) {
        header("Location: detail.php?id=" . urlencode($originalId));
        exit();
    } else {
        echo "Error updating section.";
    }
}

// Stuff for header
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);

?>

<div class="container mt-4">
    <h1>Edit Section</h1>
    <form method="post" action="edit.php?id=<?= urlencode($_GET["id"]) ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="section_name">Section Title:</label>
            <input type="text" class="form-control" id="section_name" name="title" required
                   value="<?= $sectionToEdit->getTitle() ?>">
        </div>
        <div class="form-group">
            <label for="section_description">Text:</label>
            <textarea class="form-control" id="section_description" name="text" rows="4"
                      required><?= $sectionToEdit->getContent() ?></textarea>
        </div>
        <div class="form-group">
            <label for="img_upload">Upload Image:</label>
            <input type="file" class="form-control-file" id="img_upload" name="img_upload" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php
importFooter($pathToSurface);
?>
