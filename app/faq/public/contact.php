<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
    <h1>Contact Us</h1>
    
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
        echo "<p>Thank you for your submission!</p>";
    }
    ?>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="message">Message:</label><br>
        <textarea name="message" id="message" rows="4" required></textarea><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
