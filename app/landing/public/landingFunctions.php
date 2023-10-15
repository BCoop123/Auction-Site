<?php
require_once('../../../lib/read_json.php');

function displaySections() {
    $sections = readJsonData('../../../data/landing/sections.json');
    
    foreach ($sections as $key => $section) {
        $imgPath = "../../.." . $section["img"];

        if ($key % 2 == 0) {
            echo '
            <section id="scroll">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-lg-6 order-lg-2">
                            <div class="p-5"><img class="img-fluid rounded-circle" src="' . $imgPath . '" alt="..." /></div>
                        </div>
                        <div class="col-lg-6 order-lg-1">
                            <div class="p-5">
                                <h2 class="display-4">' . $section["title"] . '</h2>
                                <p>' . $section["text"] . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            ';
        }
        else {
            echo '
            <section>
                <div class="container px-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-lg-6">
                            <div class="p-5"><img class="img-fluid rounded-circle" src="' . $imgPath . '" alt="..." /></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <h2 class="display-4">' . $section["title"] . '</h2>
                                <p>' . $section["text"] . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            ';
        }

    }
}

?>