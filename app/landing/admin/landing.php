<?php
// Creates a table that contains file names and contents of a folder
function createTable($headings, $sections) {
    echo '
    <div class="container-fluid">
        <!-- Bootstrap table -->
        <table class="table" style="width: 90%; margin: auto;">
            <thead>
                <tr>
    ';
    foreach ($headings as $heading) {
        echo '<th>' . $heading . '</th>';
    }
    echo '
                </tr>
            </thead>
            <tbody>
    ';
    foreach ($sections as $section) {
        echo '
            <tr>
                <td><a href="./detail.php?name=' . urlencode($section[1]) . '">' . $section[1] . '</a></td>
                <td>' . $section[2] . '</td>
                <td>' . $section[0] . '</td>
            </tr>
        ';
    }
    echo '
            </tbody>
        </table>
    </div>
    ';
}

function getSectionInfo($dir_path) {
    $sectionsArray = [];

    // Open the directory
    $dir_handle = opendir($dir_path);

    if ($dir_handle) {
        while (false !== ($filename = readdir($dir_handle))) {
            $file_path = $dir_path . "/" . $filename;

            // Check if it's a file and not a directory
            if (is_file($file_path)) {        
                // Fetch and decode the contents of the file
                $contents = file_get_contents($file_path);
                $sections = json_decode($contents, true); // true for associative array

                if (is_array($sections) && !empty($sections)) {
                    foreach ($sections as $section) {
                        $sectionsArray[] = [
                            $section["img"],
                            $section["title"],
                            $section["text"]
                        ];
                    }
                }
            }
        }

        // Close the directory handle
        closedir($dir_handle);
    } else {
        echo "Failed to open directory!";
    }
    return $sectionsArray;
}
function getSectionDetails($sectionName) {
    $jsonFile = "../../../data/landing/sections.json";

    if (file_exists($jsonFile)) {
        $sectionsData = json_decode(file_get_contents($jsonFile), true);

        foreach ($sectionsData as $section) {
            if ($section['title'] === $sectionName) {
                return $section;
            }
        }
    } else {
        echo "Sections file not found.";
    }

    return null;
}

function editSection($sectionName, $newData) {
    $jsonFile = "../../../data/landing/sections.json";

    if (file_exists($jsonFile)) {
        $sectionsData = json_decode(file_get_contents($jsonFile), true);

        // Search for the section by name
        foreach ($sectionsData as $index => $section) {
            if ($section['title'] === $sectionName) {
                // Overwrite the section data
                $sectionsData[$index] = $newData;

                // Save the updated data back to the file
                return file_put_contents($jsonFile, json_encode($sectionsData, JSON_PRETTY_PRINT)) !== false;
            }
        }
    } else {
        echo "Sections file not found.";
        return false;
    }
}

function deleteSection($sectionName) {
    $jsonFile = "../../../data/landing/sections.json";

    if (file_exists($jsonFile)) {
        $sectionsData = json_decode(file_get_contents($jsonFile), true);

        // Search for the section by name
        foreach ($sectionsData as $index => $section) {
            if ($section['title'] === $sectionName) {
                // Remove the section from the array
                array_splice($sectionsData, $index, 1);

                // Save the updated data back to the file
                return file_put_contents($jsonFile, json_encode($sectionsData, JSON_PRETTY_PRINT)) !== false;
            }
        }
    } else {
        echo "Sections file not found.";
        return false;
    }
}
?>