<!DOCTYPE html>
<html>
<head>
    <title>FAQ</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Frequently Asked Questions (FAQ)</h1>

        <!-- Display FAQ content in a box -->
        <div class="alert alert-info">
            <?php
            // Read FAQ content from the file
            $faqFilePath = '../../../data/faq/faq.txt';
            if (file_exists($faqFilePath)) {
                $faqContent = file_get_contents($faqFilePath);
                echo nl2br($faqContent); // Preserve line breaks
            } else {
                echo "FAQ content not available.";
            }
            ?>
        </div>
    </div>

    <!-- "Contact Us" button in the top right corner -->
    <div style="position: absolute; top: 10px; right: 10px;">
        <a href="contact.php" class="btn btn-primary">Contact Us</a>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
