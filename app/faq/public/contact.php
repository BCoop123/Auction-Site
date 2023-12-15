<?php
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
require_once("../../../lib/settings.php");  // Include the settings.php file

$pathToSurface = "../../..";

importHeader($pathToSurface);

function saveFormDataToDatabase($pdo, $name, $email, $message) {
    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO contactsection (name, email, message) VALUES (?, ?, ?)");

        // Bind parameters
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $message);

        // Execute the statement
        $stmt->execute();
    } catch (PDOException $e) {
        // Handle any errors here
        echo "<div class='alert alert-danger mt-3'>Error saving data to database: " . $e->getMessage() . "</div>";
    }
}

?>

<div class="container">
    <h1 class="mt-5">Contact Us</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        // Save form data to the database
        saveFormDataToDatabase($pdo, $name, $email, $message);

        // Display a success message
        echo "<div class='alert alert-success mt-3'>Thank you for your submission!</div>";
    }
    ?>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" name="message" id="message" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 20px">Submit</button>
        </form>

        <!-- Back button to go back a page -->
        <a href="javascript:history.back()" class="btn btn-secondary mt-3" style="margin-bottom: 20px">Back</a>
    </div>

<!-- Footer-->
<?php
importFooter($pathToSurface);
?> 

