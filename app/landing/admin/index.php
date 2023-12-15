<?php
$dir_path = "../../../data/landing";
$headings = ["Title", "Text", "IMG"];

//stuff for header
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);

if (isset($_SESSION["user_id"]) && (isset($_SESSION["permission"]))) {
    if ($_SESSION["permission"] == 1) {
        require_once("../public/landingFunctions.php");

        echo '
        <div class="text-center mt-4">
            <a href="create.php" class="btn btn-primary button-margin">Create New</a>
        </div>
        ';

        LandingSections::displayLandingSectionsTable($headings);
    }
    else {
        echo '
            You cannot see this page!
        ';
    }
}

else {
    echo '
        You cannot see this page!
    ';
}

//stuff for footer
importFooter($pathToSurface);
?>