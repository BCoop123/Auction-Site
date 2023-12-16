<?php
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
require_once("../../../lib/settings.php");  // Include the settings.php file

$pathToSurface = "../../..";

importHeader($pathToSurface);

// Load the contact data from the database
try {
    // Prepare the SQL statement to retrieve contact data from the database
    $stmt = $pdo->prepare("SELECT * FROM contactsection");
    $stmt->execute();

    // Fetch all results
    $contactsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle any errors here
    echo "<div class='alert alert-danger mt-3'>Error retrieving contact data: " . $e->getMessage() . "</div>";
    exit;
}

$headings = ["Name", "Email", "Message"];

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
                    echo "<td>{$contact[strtolower($headingKey)]}</td>";
                }
                // Add a link to view the contact's details
                if (isset($contact['contact_id'])) {
                    echo "<td><a href='detail.php?id={$contact['contact_id']}' class='btn btn-primary'>View Details</a></td>";
                } else {
                    echo "<td>Id not available</td>";
                }

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
