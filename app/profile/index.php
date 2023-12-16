<?php
require_once("../../lib/multipageFunctions.php");
require_once("../../themes/components/header_footer_import.php");
$pathToSurface = "../..";
// Include database connection and path config
require_once($pathToSurface . '/lib/settings.php');

importHeader($pathToSurface);

?>

<div class="container mt-5">
    <?php
        $pathToSurface = "../..";

        function updateProfile($username, $newBio, $uploadedFile, $filePath, $pathToSurface) {
            $existingData = file_get_contents($filePath);
            $profiles = json_decode($existingData, true);
        
            foreach ($profiles as &$profile) {
                if ($profile["username"] == $username) {
                    // Update the bio
                    $profile["bio"] = $newBio;
        
                    // Update the profile image if a new file has been uploaded
                    if ($uploadedFile && $uploadedFile['error'] == 0) {
                        $check = getimagesize($uploadedFile["tmp_name"]);
                        if($check !== false) {
                            $targetDir = $pathToSurface . "/data/profile/img/";
                            $fileExtension = pathinfo($uploadedFile["name"], PATHINFO_EXTENSION);
                            $randomName = rand() . "." . $fileExtension;
                            $targetFile = $targetDir . $randomName;
        
                            // Delete old image unless it's account.png
                            $oldImage = $profile["profileIMG"];
                            if (basename($oldImage) !== "account.png" && file_exists($pathToSurface . $oldImage)) {
                                unlink($pathToSurface . $oldImage);
                            }
        
                            // Attempt to move the uploaded file
                            if (move_uploaded_file($uploadedFile["tmp_name"], $targetFile)) {
                                $profile["profileIMG"] = "/data/profile/img/" . $randomName;
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                                return;
                            }
                        } else {
                            echo "File is not an image.";
                            return;
                        }
                    }
                }
            }
        
        }        
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
            $username = $_SESSION["user_id"];
            $bio = $_POST["bio"];
            $uploadedFile = $_FILES["profileIMG"];
        
            updateProfile($username, $bio, $uploadedFile, '../../data/profile/profiles.json', $pathToSurface);
        }
        

        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];

            // Load profiles data
            $sql = "SELECT user_id, username, bio, image_name
                FROM image i
                JOIN bidoramauser b
                ON i.image_id = b.image_id
                WHERE user_id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id]);

            $result = $stmt->fetch();

            if ($result) {

                $fullPath = $pathToSurface . "/data/profile/img/" . $result["image_name"];
                $username = $result["username"];
                $bio = $result["bio"];

                // Display profile information
                echo "<div class='text-center'>";
                echo "<img src='$fullPath' alt='Profile Image' class='rounded-circle' style='width: 150px; height: 150px;'>";
                echo "<h2>$username</h2>";
                echo "<p>$bio</p>";
                echo "<button class='btn btn-primary' data-toggle='modal' data-target='#editProfileModal' style='margin-bottom: 20px'>Edit Profile</button>";
                echo "</div>";
            } else {
                echo "<p class='text-danger'>Profile not found!</p>";
            }

        } else {
            echo "<p class='text-danger'>User not logged in!</p>";
        }
    ?>
</div>

<!-- Modal for Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="profileIMG">Upload Profile Image</label>
                        <input type="file" class="form-control-file" id="profileIMG" name="profileIMG">
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo $userProfile["bio"] ?? ''; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional Bootstrap JS (jQuery first, then Popper.js, then Bootstrap JS) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
        importFooter($pathToSurface);
?> 
