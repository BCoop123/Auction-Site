<?php
// Creates a table that contains file names and contents of a folder
function createTable($headings, $files) {
    echo '
    <div class="container-fluid">
        <!-- Bootstrap table -->
        <table class="table" style="width: 90%; margin: auto;">
            <thead>
                <tr>
    ';
    foreach ($headings as $key => $heading) {
        echo '
            <th>' . $heading . '</th>
        ';
    };
    echo '
                </tr>
            </thead>
            <tbody>
    ';
    foreach ($files as $key => $file) {
        echo '
            <tr>
                <td><a href="./detail.php?award=' . urlencode($file[0]) . '">' . $file[0] . '</a></td>
                <td>' . $file[1] . '</td>
            </tr>
        ';
    };
    echo '
            </tbody>
        </table>
    </div>
    ';
}

function getAwardInfo($dir_path) {
    $productsArray = [];

    // Open the directory
    $dir_handle = opendir($dir_path);

    if ($dir_handle) {
        while (false !== ($filename = readdir($dir_handle))) {
            $file_path = $dir_path . "/" . $filename;

            // Check if it's a CSV file and not a directory
            if (is_file($file_path) && pathinfo($file_path, PATHINFO_EXTENSION) === 'csv') {        

                // Open the CSV file for reading
                if (($handle = fopen($file_path, "r")) !== FALSE) {

                    // Read each line of CSV and store the data
                    while (($product = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $productsArray[] = [
                            $product[0],
                            $product[1]
                        ];
                    }
                    fclose($handle);
                }
            }
        }

        // Close the directory handle
        closedir($dir_handle);
    } else {
        echo "Failed to open directory!";
    }
    return $productsArray;
}

function deleteAwardFromCSV($csvFileName, $awardName) {
    // Check if the CSV file exists
    if (file_exists($csvFileName)) {
        // Read the CSV file into an array
        $csvData = file($csvFileName);
        $newCsvData = [];

        foreach ($csvData as $line) {
            // Split the CSV line into columns
            $columns = str_getcsv($line);
            
            // Check if the first column matches the award name
            if (trim($columns[0], '"') !== $awardName) {
                $newCsvData[] = $line;  // Store lines that don't match the award name
            }
        }

        // Write the updated data back to the CSV file
        file_put_contents($csvFileName, implode('', $newCsvData));

        // Return true if the new data is shorter than the original data, meaning an award was deleted
        return count($newCsvData) < count($csvData);
    } else {
        // CSV file does not exist
        return false;
    }
}

function getAwardDetails($csv_path, $awardName) {
    $awardDetails = null;

    if (is_file($csv_path) && pathinfo($csv_path, PATHINFO_EXTENSION) === 'csv') {        
        if (($handle = fopen($csv_path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($data[0] === $awardName) { // Check if the first column matches the award name
                    $awardDetails = $data;
                    break;
                }
            }
            fclose($handle);
        }
    }

    return $awardDetails;
}

function addOrUpdateAward($csvFileName, $awardName, $awardDescription) {
    // The array that will contain all awards from the CSV file
    $awardsArray = [];

    // Check if the CSV file exists
    if (file_exists($csvFileName)) {
        // Read the CSV file into an array
        $csvData = file($csvFileName);

        foreach ($csvData as $line) {
            $awardsArray[] = str_getcsv($line);
        }

        // Flag to check if an update is performed
        $updated = false;

        // Search for an existing award with the same name and update it if found
        foreach ($awardsArray as &$award) {
            if ($award[0] === $awardName) {
                $award[1] = $awardDescription;
                $updated = true;
                break;
            }
        }

        // If no award was found, add a new one
        if (!$updated) {
            $awardsArray[] = [$awardName, $awardDescription];
        }

        // Convert the awards array back to CSV format
        $csvOutput = "";
        foreach ($awardsArray as $award) {
            $csvOutput .= '"' . implode('","', $award) . '"' . PHP_EOL;
        }

        // Write the CSV data back to the file
        return file_put_contents($csvFileName, $csvOutput) !== false;
    } else {
        // CSV file does not exist
        return false;
    }
}

function deleteAward($csvFileName, $awardName) {
    $awardsArray = [];

    if (file_exists($csvFileName)) {
        $csvData = file($csvFileName);

        foreach ($csvData as $line) {
            $awardsArray[] = str_getcsv($line);
        }

        foreach ($awardsArray as $key => $award) {
            if ($award[0] === $awardName) {
                unset($awardsArray[$key]);
                break;
            }
        }

        $csvOutput = "";
        foreach ($awardsArray as $award) {
            $csvOutput .= '"' . implode('","', $award) . '"' . PHP_EOL;
        }

        return file_put_contents($csvFileName, $csvOutput) !== false;
    } else {
        return false;
    }
}

function addNewAward($awardsFile, $name, $description) {
    // Open the CSV file for writing (append mode)
    $file = fopen($awardsFile, "a");

    // Check if the file was opened successfully
    if ($file) {
        // Prepare the data as a CSV line
        $newAward = '"' . $name . '","' . $description . '"';
        
        // Write the new award data to the file
        fwrite($file, $newAward . PHP_EOL);

        // Close the file
        fclose($file);

        return true; // Return true on success
    } else {
        return false; // Return false on failure
    }
}

?>
