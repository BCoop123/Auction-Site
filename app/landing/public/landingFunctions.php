<?php

//================================================================================
// Utility Class for Awards
//================================================================================

class LandingSections {

    //================================================================================
    // Display All Sections
    //================================================================================

    //display sections
    public static function displayLandingSections() {
        //get array of sections
        $sections = self::readLandingSections();
        $sectionFormat = "imageRight";

        foreach ($sections as $key => $section) {
            

            if ($sectionFormat == "imgRight") {
                $section->printLandingSectionRight();
                $sectionFormat = "imgLeft";
            }
            else {
                $section->printLandingSectionLeft();
                $sectionFormat = "imgRight";
            }
        };

    }

    //display section
    public static function displayLandingSection($section_id) {
        //get array of sections
        $section = self::readLandingSection($section_id);

        echo '
        <div class="text-center mt-4">
            <a href="edit.php?id='. urlencode($section->getSectionId()) .'" class="btn btn-primary button-margin">Edit</a>
        </div>
        <div class="text-center mt-4">
            <a href="delete.php?id='. urlencode($section->getSectionId()) .'" class="btn btn-danger button-margin">Delete</a>
        </div>
        <div class="container">
            <h1>'. $section->getTitle() .'Details</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>IMG</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'. $section->getTitle() .'</td>
                        <td>'. $section->getContent() .'</td>
                        <td><img src="'. $section->getImage() .'" width="100" height="100" alt="Section Image"></td>
                    </tr>
                </tbody>
            </table>
            <a href="index.php">Back to Sections</a>
        </div>
        ';

    }

    //display sections in a table format
    public static function displayLandingSectionsTable($headings) {
        //get array of sections
        $sections = self::readLandingSections();

        //print top of table
        echo '
        <div class="container-fluid">
            <!-- Bootstrap table -->
            <table class="table" style="width: 90%; margin: auto;">
                <thead>
                    <tr>
        ';

        //print section headings
        foreach ($headings as $heading) {
            echo '<th>' . $heading . '</th>';
        }

        //print end of headings row
        echo '
                    </tr>
                </thead>
                <tbody>
        ';

        //print all the sections
        foreach ($sections as $key => $section) {
            $section->printLandingSectionRow();
        };

        //print bottom of table
        echo '
        </tbody>
            </table>
        </div>
        ';

    }

    //================================================================================
    // Read Sections from Database
    //================================================================================

    //read all sections
    public static function readLandingSections() {
        // Include database connection and path config
        require_once('../../../lib/settings.php');

        // Logic that gets the realitive path and root directory
        $currentScriptDirectory = dirname(__FILE__); // or __DIR__ in PHP 5.3 and later
        $rootDirectory = getRootDirectory();
        $relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

        $result = $pdo->query(
            'SELECT landing_id
                ,title
                ,content
                ,image_name
            FROM landingsection AS ls
            JOIN image AS i
                ON ls.image_id = i.image_id
        ');

        // Initilize the array for sections and create class instances for sections
        $sectionsArray = [];

        while ($section = $result->fetch()) {
            $sectionsArray[] = new LandingSection($section["landing_id"], $section["title"], $section["content"], $relativePathToRoot . "data" . DIRECTORY_SEPARATOR . "landing" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $section["image_name"]);
        }

        return $sectionsArray;
    }

    //read a section with a certian ID
    public static function readLandingSection($section_id) {
        // Include database connection and path config
        require_once('../../../lib/settings.php');

        // Logic that gets the realitive path and root directory
        $currentScriptDirectory = dirname(__FILE__); // or __DIR__ in PHP 5.3 and later
        $rootDirectory = getRootDirectory();
        $relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

        $sql = 'SELECT landing_id
                    ,title
                    ,content
                    ,image_name
                FROM landingsection AS ls
                JOIN image AS i
                    ON ls.image_id = i.image_id
                WHERE landing_id = ?
            ';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$section_id]);

        // Create class instances for sections

        $section = $stmt->fetch();
        $section = new LandingSection($section["landing_id"], $section["title"], $section["content"], $relativePathToRoot . "data" . DIRECTORY_SEPARATOR . "landing" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $section["image_name"]);

        return $section;
    }

    //================================================================================
    // Create Section in Database
    //================================================================================

    public static function createLandingSection($image_name, $title, $content) {
        // Include database connection and path config
        require_once('../../../lib/settings.php');

        // Logic that gets the realitive path and root directory
        $currentScriptDirectory = dirname(__FILE__); // or __DIR__ in PHP 5.3 and later
        $rootDirectory = getRootDirectory();
        $relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

        $sql = "INSERT INTO image
                    (
                        image_name
                    )
                    VALUES
                    (
                        ?
                    )
                ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$image_name]);
        $image_id = $pdo->lastInsertId();

        $sql = "INSERT INTO landingsection
                    (
                        title
                        ,content
                        ,image_id
                    )
                    VALUES
                    (
                        ?
                        ,?
                        ,?
                    )
                ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $content, $image_id]);
        $landingSectionId = $pdo->lastInsertId();

        return $setLandingId;

    }

    //================================================================================
    // Update Section in Database
    //================================================================================

    public static function editLandingSection($section_id, $title, $content, $newImageName) {
        // Include database connection and path config
        require_once('../../../lib/db.php');
        
        // Logic that gets the relative path and root directory
        $currentScriptDirectory = dirname(__FILE__); // or __DIR__ in PHP 5.3 and later
        $rootDirectory = getRootDirectory();
        $relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);
    
        // Retrieve the existing image_id directly in this function
        $sql = 'SELECT image_id
                FROM landingsection
                WHERE landing_id = ?
            ';
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$section_id]);
        $existingImageId = $stmt->fetchColumn(); // Use fetchColumn to get a single value
    
        // Update the landingsection table
        $sql = "UPDATE landingsection
                SET
                    title = ?,
                    content = ?
                WHERE
                    landing_id = ?
                ";
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $content, $section_id]);
    
        // Update the image table only if the image has changed
        if ($existingImageId !== false) {
            $sql = "UPDATE image
                    SET
                        image_name = ?
                    WHERE
                        image_id = ?
                    ";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$newImageName, $existingImageId]);
        }
    
        return $section_id; // Assuming you want to return the section_id after the edit
    }
    

    //================================================================================
    // Delete Section in Database
    //================================================================================

    public static function deleteLandingSection($section_id) {
        // Include database connection and path config
        require_once('../../../lib/db.php');

        // Logic that gets the realitive path and root directory
        $currentScriptDirectory = dirname(__FILE__); // or __DIR__ in PHP 5.3 and later
        $rootDirectory = getRootDirectory();
        $relativePathToRoot = getRelativePathToRoot($currentScriptDirectory, $rootDirectory);

        $sql = "DELETE FROM landingsection
                WHERE landing_id = ?
                ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$section_id]);

        return True;
    }
}

//================================================================================
// Class for LandingSection
//================================================================================

class LandingSection {
    //specify private variables
    private $landing_id;
    private $title;
    private $content;
    private $image_path;

    //constructor
    public function __construct($landing_id, $title, $content, $image_path) {
        $this -> setLandingId($landing_id);
        $this -> setTitle($title);
        $this -> setContent($content);
        $this -> setImage($image_path);
    }

    public function setLandingId($landing_id) {
        $this -> landing_id = $landing_id;
    }

    public function setTitle($title) {
        $this -> title = $title;
    }

    public function setContent($content) {
        $this -> content = $content;
    }

    public function setImage($image_path) {
        $this -> image_path = $image_path;
    }

    public function getSectionId() {
        return $this -> landing_id;
    }

    public function getTitle() {
        return $this -> title;
    }

    public function getContent() {
        return $this -> content;
    }

    public function getImage() {
        return $this -> image_path;
    }

    public function printLandingSectionLeft() {
        echo '
            <section>
                <div class="container px-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-lg-6">
                            <div class="p-5"><img class="img-fluid rounded-circle" src="' . $this->image_path . '" alt="..." /></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <h2 class="display-4">' . $this->title . '</h2>
                                <p>' . $this->content . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        ';
    }

    public function printLandingSectionRight() {
        echo '
            <section id="scroll">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-lg-6 order-lg-2">
                            <div class="p-5"><img class="img-fluid rounded-circle" src="' . $this->image_path . '" alt="..." /></div>
                        </div>
                        <div class="col-lg-6 order-lg-1">
                            <div class="p-5">
                                <h2 class="display-4">' . $this->title . '</h2>
                                <p>' . $this->content . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        ';
    }

    public function printLandingSectionRow() {
        echo '
            <tr>
                <td><a href="./detail.php?id=' . urlencode($this->landing_id) . '">' . $this->title . '</a></td>
                <td>' . $this->content . '</td>
                <td><img src="' . $this->image_path . '" width="100" height="100" alt="Section Image"></td>
            </tr>
        ';
    }
}

?>