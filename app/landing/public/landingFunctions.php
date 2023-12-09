<?php

function displaySections() {
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

    //Set the format that the section is displayed in either img right or img left
    $sectionFormat = "imgRight";

    while ($section = $result->fetch()) {

        if ($sectionFormat == "imgRight") {
            echo '
            <section id="scroll">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-lg-6 order-lg-2">
                            <div class="p-5"><img class="img-fluid rounded-circle" src="' . $relativePathToRoot . 'data' . DIRECTORY_SEPARATOR . 'landing' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $section["image_name"] . '" alt="..." /></div>
                        </div>
                        <div class="col-lg-6 order-lg-1">
                            <div class="p-5">
                                <h2 class="display-4">' . $section["title"] . '</h2>
                                <p>' . $section["content"] . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            ';
            $sectionFormat = "imgLeft";
        }
        else {
            echo '
            <section>
                <div class="container px-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-lg-6">
                            <div class="p-5"><img class="img-fluid rounded-circle" src="' . $relativePathToRoot . 'data' . DIRECTORY_SEPARATOR . 'landing' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $section["image_name"] . '" alt="..." /></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <h2 class="display-4">' . $section["title"] . '</h2>
                                <p>' . $section["content"] . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            ';
            $sectionFormat = "imgRight";
        }

    }
}

?>