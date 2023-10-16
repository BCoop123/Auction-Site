<?php
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
$pathToSurface = "../../..";

importHeader($pathToSurface);

$dir_path = "../../../data/contact"; // Update the directory path as needed
$contactsFilePath = "{$dir_path}/contact.json";
$headings = ["Name", "Email", "Message"]; // Update the headings to match your JSON keys

// Load the contact data from the JSON file
$contactsData = json_decode(file_get_contents($contactsFilePath), true);
?>

    <div class="container">
        <h1 class="mt-5">Contact List</h1>

        <!-- Create a table to display the contact list -->
        <table class="table">
            <thead>
                <tr>
                    <?php
                    foreach ($headings as $heading) {
                        echo "<th>{$heading}</th>";
                    }
                    ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the contact data and display each contact's information
                foreach ($contactsData as $key => $contact) {
                    echo "<tr>";
                    foreach ($headings as $headingKey) {
                        echo "<td>{$contact[strtolower($headingKey)]}</td>"; // Use strtolower to match JSON keys
                    }
                    // Add a link to view the contact's details
                    echo "<td><a href='detail.php?file={$key}' class='btn btn-primary'>View Details</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Add a button to go back a page -->
        <a href="javascript:history.back()" class="btn btn-secondary mt-3">Back</a>
        
        <!-- Add a green "Edit FAQ Page" button at the bottom -->
        <a href="editfaq.php" class="btn btn-success mt-3">Edit FAQ Page</a>
    </div>

<!-- Footer-->
<?php
importFooter($pathToSurface);
?> 
