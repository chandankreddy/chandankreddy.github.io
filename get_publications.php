<?php
$dir = 'files'; // Directory containing your publication files
$publications = [];

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            // Check if the file name matches the specified format (e.g., 'AAAI23')
            if (preg_match('/^[A-Z]{4}\d{2}$/', $file)) {
                // Extract year from the filename
                $year = 2000 + intval(substr($file, -2));
                
                // You can extract other information from the file if needed
                // For example, you might want to read the contents of each file.

                // Add publication to the array
                $publications[] = [
                    'year' => $year,
                    'title' => $file,
                ];
            }
        }
        closedir($dh);
    }
}

// Output JSON data
header('Content-Type: application/json');
echo json_encode($publications);
?>
