<?php
$contactsFilePath = "../../../data/contact/contact.json"; // Update the file path
$contactIndex = isset($_GET['file']) ? (int)$_GET['file'] : -1; // Get the contact index from the URL

// Load the contact data from the JSON file
$contactsData = json_decode(file_get_contents($contactsFilePath), true);

// Check if the contact index is valid
if ($contactIndex >= 0 && $contactIndex < count($contactsData)) {
    $contactDetails = $contactsData[$contactIndex];
} else {
    echo "Contact not found.";
    exit;
}

// Delete the contact entry if the delete button is clicked
if (isset($_POST['delete'])) {
    unset($contactsData[$contactIndex]);
    $contactsData = array_values($contactsData); // Reindex the array
    $jsonData = json_encode($contactsData, JSON_PRETTY_PRINT);
    file_put_contents($contactsFilePath, $jsonData);
    header("Location: index.php"); // Redirect back to the contact list
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
                <tr>
                    <td>Name</td>
                    <td><?php echo $contactDetails['name']; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $contactDetails['email']; ?></td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td><?php echo $contactDetails['message']; ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Add a delete button to remove the contact entry -->
        <form method="post">
            <input type="submit" name="delete" value="Delete Entry" class="btn btn-danger">
        </form>

        <!-- Add a button to go back to the contact list -->
        <a href="index.php" class="btn btn-secondary mt-3">Back to Contacts</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
