<?php
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
require_once("../../../lib/settings.php");  // Include the settings.php file

$pathToSurface = "../../..";

importHeader($pathToSurface);

// Get the contact ID from the URL
$contactId = isset($_GET['id']) ? (int)$_GET['id'] : -1;

// Load the contact data from the database
try {
    // Prepare the SQL statement to retrieve contact data from the database based on ID
    $stmt = $pdo->prepare("SELECT * FROM contactsection WHERE contact_id = :id");
    $stmt->bindParam(':id', $contactId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the result
    $contactDetails = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle any errors here
    echo "<div class='alert alert-danger mt-3'>Error retrieving contact details: " . $e->getMessage() . "</div>";
    exit;
}

// Check if the contact details are valid
if (!$contactDetails) {
    echo "Contact not found.";
    exit;
}

// Delete the contact entry if the delete button is clicked
if (isset($_POST['delete'])) {
    try {
        // Prepare the SQL statement to delete the contact entry from the database
        $stmt = $pdo->prepare("DELETE FROM contactsection WHERE contact_id = :id");
        $stmt->bindParam(':id', $contactId, PDO::PARAM_INT);
        $stmt->execute();
        //header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors here
        echo "<div class='alert alert-danger mt-3'>Error deleting contact entry: " . $e->getMessage() . "</div>";
    }
}

?>

<div class="container">
    <h1 class="mt-5">Contact Details</h1>

    <!-- Display contact details -->
    <table class="table">
        <thead>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($contactDetails as $key => $value) {
                echo "<tr>";
                echo "<td>" . ucwords(str_replace("_", " ", $key)) . "</td>"; // Convert column names to title case
                echo "<td>{$value}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Add a delete button to remove the contact entry -->
    <form method="post" action="deletecontact.php?id=<?php echo $contactId; ?>">
        <input type="submit" name="delete" value="Delete Entry" class="btn btn-danger">
    </form>

    <!-- Add a button to go back to the contact list -->
    <a href="index.php" class="btn btn-secondary mt-3">Back to Contacts</a>
</div>

<!-- Footer-->
<?php
importFooter($pathToSurface);
?>

