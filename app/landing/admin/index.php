<?php
$dir_path = "../../../data/landing";
$headings = ["Title", "Text", "IMG"];
require_once('./landing.php');

//stuff for header
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);

?>

<div class="text-center mt-4">
    <a href="create.php" class="btn btn-primary button-margin">Create New</a>
</div>

<?php
    createTable($headings, getSectionInfo($dir_path));
    importFooter($pathToSurface);
?>