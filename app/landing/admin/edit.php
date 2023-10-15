<?php
require_once('./landing.php');

$sectionToEdit = getSectionDetails($_GET["name"]);
$sectionsFile = "../../../data/landing/sections.json";
$pathToRoot =  "../../..";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $originalName = $_GET["name"];
    $newName = $_POST["title"];
    $text = $_POST["text"];

    $oldImgPath = $sectionToEdit['img']; // Store old image path for deletion later

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

    // Remove the old image from the directory
    if (file_exists($pathToRoot . $oldImgPath) && is_writable($pathToRoot . $oldImgPath)) {
        unlink($pathToRoot . $oldImgPath);
    }

    $newData = [
        "img" => $imgPath,
        "title" => $newName,
        "text" => $text
    ];

    if (editSection($originalName, $newData)) {
        header("Location: detail.php?name=" . urlencode($newName));
        exit();
    } else {
        echo "Error updating section.";
    }
}

//stuff for header
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);

?>

<div class="container mt-4">
    <h1>Edit Section</h1>
    <form method="post" action="edit.php?name=<?= urlencode($_GET["name"]) ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="section_name">Section Title:</label>
            <input type="text" class="form-control" id="section_name" name="title" required
                   value="<?= $sectionToEdit['title'] ?>">
        </div>
        <div class="form-group">
            <label for="section_description">Text:</label>
            <textarea class="form-control" id="section_description" name="text" rows="4"
                      required><?= $sectionToEdit['text'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="img_upload">Upload Image:</label>
            <input type="file" class="form-control-file" id="img_upload" name="img_upload" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php
    importFooter($pathToSurface);
?>