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

//stuff for header
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);
?>

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
                <td><img src="../../../<?php echo $sectionInfo['img']; ?>" width="100" height="100" alt="Section Image"></td>
            </tr>
        </tbody>
    </table>
    <a href="index.php">Back to Sections</a>
</div>

<?php
    importFooter($pathToSurface);
?>