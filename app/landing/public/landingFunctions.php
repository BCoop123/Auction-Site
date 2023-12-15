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
        $sectionArray = [];

        while ($section = $result->fetch()) {
            $sectionArray[] = new LandingSection($section["landing_id"], $section["title"], $section["content"], $relativePathToRoot . "data" . DIRECTORY_SEPARATOR . "landing" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $section["image_name"]);
        }

        return $sectionArray;
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

    // TODO

    //================================================================================
    // Delete Section in Database
    //================================================================================

    // TODO
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