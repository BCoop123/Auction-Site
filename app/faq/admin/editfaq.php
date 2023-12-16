<?php
require_once("../../../lib/multipageFunctions.php");
require_once("../../../themes/components/header_footer_import.php");
require_once("redirectfaq.php");

$pathToSurface = "../../..";

importHeader($pathToSurface);

// Read the current FAQ content from the database
try {
    // Prepare the SQL statement to retrieve FAQ questions and responses from the database
    $stmt = $pdo->prepare("SELECT question, response FROM faqsection LIMIT 1");
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if content is available
    if ($result) {
        $currentQuestion = $result['question'];
        $currentResponse = $result['response'];
    } else {
        $currentQuestion = '';
        $currentResponse = '';
    }
} catch (PDOException $e) {
    // Handle any errors here
    echo "<div class='alert alert-danger mt-3'>Error retrieving FAQ content: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit FAQ</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit FAQ</h1>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="newQuestion">Edit FAQ Question:</label>
                <textarea class="form-control" name="newQuestion" id="newQuestion" rows="5"><?php echo $currentQuestion; ?></textarea>
            </div>

            <div class="form-group">
                <label for="newResponse">Edit FAQ Response:</label>
                <textarea class="form-control" name="newResponse" id="newResponse" rows="10"><?php echo $currentResponse; ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
            <a href="index.php" class="btn btn-secondary">Go Back</a>
        </form>
    </div>

    <!-- Footer-->
    <?php
    importFooter($pathToSurface);
    ?>
</body>
</html>

