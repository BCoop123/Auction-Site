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
            $sectionArray[] = new LandingSection($section["title"], $section["content"], $relativePathToRoot . "data" . DIRECTORY_SEPARATOR . "landing" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . $section["image_name"]);
        }

        return $sectionArray;
    }

    //================================================================================
    // Create Section in Database
    //================================================================================

    // TODO

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
    private $title;
    private $content;
    private $image_path;

    //constructor
    public function __construct($title, $content, $image_path) {
        $this -> setTitle($title);
        $this -> setContent($content);
        $this -> setImage($image_path);
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
}

?>