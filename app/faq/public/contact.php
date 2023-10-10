<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Contact Us</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $message = $_POST["message"];

            // Create an array to store the form data
            $formData = array(
                "name" => $name,
                "email" => $email,
                "message" => $message
            );

        // Load existing data from contacts.json
        $existingData = json_decode(file_get_contents("../../../data/contact/contact.json"), true);
        
        // Add the new form data to the existing data
        $existingData[] = $formData;

            // Encode the updated data as JSON
            $jsonData = json_encode($existingData, JSON_PRETTY_PRINT);

        // Save the JSON data back to contacts.json
        file_put_contents("../../../data/contact/contact.json", $jsonData);

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

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

