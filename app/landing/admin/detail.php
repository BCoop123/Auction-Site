<?php
require_once('./landing.php');
require_once('../public/landingFunctions.php');

// Check if the 'name' parameter is set in the URL
if (isset($_GET['id'])) {
    $section_id = $_GET['id'];
}
// if (!$landingSection) {
//     echo "Section not found.";
//     exit;
// }

// } else {
//     echo "No section specified.";
//     exit;
// }

//stuff for header
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);

LandingSections::displayLandingSection($section_id);

importFooter($pathToSurface);
?>