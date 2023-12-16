<?php

class ProfilePage
{
    private $pathToSurface;
    private $username;
    private $userProfile;

    public function __construct($pathToSurface)
    {
        $this->pathToSurface = $pathToSurface;
        $this->username = isset($_COOKIE["username"]) ? $_COOKIE["username"] : null;
    }

    private function importHeader()
    {
        require_once("{$this->pathToSurface}/lib/multipageFunctions.php");
        require_once("{$this->pathToSurface}/themes/components/header_footer_import.php");

        importHeader($this->pathToSurface);
    }

    private function importFooter()
    {
        importFooter($this->pathToSurface);
    }

    private function updateProfile($newBio, $uploadedFile)
    {
        // Update profile logic
        // ...
    }

    private function loadUserProfile()
    {
        // Load profiles data
        $data = file_get_contents("{$this->pathToSurface}/data/profile/profiles.json");
        $profiles = json_decode($data, true);

        foreach ($profiles as $profile) {
            if ($profile["username"] == $this->username) {
                $this->userProfile = $profile;
                break;
            }
        
            // Save the updated profiles data back to the JSON file
            $jsonContent = json_encode($profiles, JSON_PRETTY_PRINT);
            if (file_put_contents($filePath, $jsonContent) !== false) {
                //echo "Profile updated successfully!";
            } else {
                //echo "Error updating profile.";
            }
        }        
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
            $username = $_SESSION["user_id"];
            $bio = $_POST["bio"];
            $uploadedFile = $_FILES["profileIMG"];

            $this->updateProfile($newBio, $uploadedFile);
        }
    }

        if (isset($_SESSION["user_id"])) {
            $username = $_SESSION["user_id"];

        echo "<div class='container mt-5'>";

        if ($this->userProfile) {
            $fullPath = $this->pathToSurface . $this->userProfile["profileIMG"];

            // Display profile information
            echo "<div class='text-center'>";
            echo "<img src='$fullPath' alt='Profile Image' class='rounded-circle' style='width: 150px; height: 150px;'>";
            echo "<h2>{$this->userProfile["username"]}</h2>";
            echo "<p>{$this->userProfile["bio"]}</p>";
            echo "<button class='btn btn-primary' data-toggle='modal' data-target='#editProfileModal' style='margin-bottom: 20px'>Edit Profile</button>";
            echo "</div>";
        } else {
            echo "<p class='text-danger'>Profile not found!</p>";
        }

        echo "</div>";
    }

    public function renderModal()
    {
        ?>
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
        <?php
    }

    public function renderPage()
    {
        $this->importHeader();
        $this->processForm();
        $this->renderProfile();
        $this->renderModal();
        $this->importFooter();
    }
}

// Create an instance of the ProfilePage class
$profilePage = new ProfilePage("../..");

// Render the entire profile page
$profilePage->renderPage();
?>

