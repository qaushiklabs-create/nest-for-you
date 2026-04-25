<?php
// Define the root directory to scan
$rootDir = '/home/lbm0yd8awsua/public_html'; // Adjust this to your actual root directory

// Define the keyword to search for and the replacement keyword
$search = ''; // The keyword you want to replace
$replace = ''; // The replacement keyword

// Function to scan directories and replace keywords
function scanAndReplace($dir, $search, $replace) {
    // Open the directory
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            // Skip '.' and '..' directories
            if ($file != "." && $file != "..") {
                $filePath = $dir . '/' . $file;

                // If it's a directory, recursively scan it
                if (is_dir($filePath)) {
                    scanAndReplace($filePath, $search, $replace);
                }
                // If it's a file, process the file
                elseif (is_file($filePath)) {
                    // Get the file contents
                    $content = file_get_contents($filePath);

                    // Replace the keyword if found
                    if (strpos($content, $search) !== false) {
                        $newContent = str_replace($search, $replace, $content);
                        
                        // Write the updated content back to the file
                        file_put_contents($filePath, $newContent);

                        // Output the modified file path for confirmation
                        echo "Updated: " . $filePath . "<br>";
                    }
                }
            }
        }
        closedir($handle);
    }
}

// Start scanning and replacing
scanAndReplace($rootDir, $search, $replace);

echo "Keyword replacement completed!";
?>
