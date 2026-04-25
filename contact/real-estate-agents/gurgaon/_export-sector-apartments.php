<?php
// public_html/export-sector-apartments.php

header("Content-Type: text/plain; charset=utf-8");

/**
 * ✅ TARGET DIRECTORY (explicit path)
 * This is what we want to scan
 */
$baseDir = $_SERVER['DOCUMENT_ROOT'] . "/contact/real-estate-agents/gurgaon";

// Safety check
if (!is_dir($baseDir)) {
  echo "ERROR: Target directory not found:\n$baseDir\n";
  exit;
}

// Exclude these filenames anywhere
$excludeFilesExact = [
  ".", "..",
  "error_log", ".htaccess", "index.php", "index.html",
  "get-apartments.php"
];

// Exclude files by extension
$excludeExtensions = [
  "log", "txt"
];

// Only include apartment pages with these extensions
$includeExtensions = [
  "php", "html", "htm"
];

// Remove extension from apartment name
$removeExtensionInName = true;

// Exclude files starting with "_"
$excludeUnderscorePrefix = true;

// Helper
function ext_of($filename) {
  $pos = strrpos($filename, ".");
  return ($pos === false) ? "" : strtolower(substr($filename, $pos + 1));
}

// Collect rows: [Sector, Apartment]
$rows = [];

$dirs = scandir($baseDir);
foreach ($dirs as $sectorFolder) {
  if ($sectorFolder === "." || $sectorFolder === "..") continue;
  if (strpos($sectorFolder, ".") === 0) continue;

  $sectorPath = $baseDir . DIRECTORY_SEPARATOR . $sectorFolder;
  if (!is_dir($sectorPath)) continue; // sector must be a folder

  $files = scandir($sectorPath);
  foreach ($files as $file) {
    if (in_array($file, $excludeFilesExact, true)) continue;
    if (strpos($file, ".") === 0) continue;
    if ($excludeUnderscorePrefix && strpos($file, "_") === 0) continue;

    $filePath = $sectorPath . DIRECTORY_SEPARATOR . $file;
    if (!is_file($filePath)) continue;

    $ext = ext_of($file);
    if (in_array($ext, $excludeExtensions, true)) continue;
    if (!in_array($ext, $includeExtensions, true)) continue;

    $apartmentName = $file;
    if ($removeExtensionInName) {
      $apartmentName = preg_replace('/\.(php|html?|htm)$/i', '', $apartmentName);
    }

    $rows[] = [$sectorFolder, $apartmentName];
  }
}

// Sort by Sector → Apartment
usort($rows, function($a, $b){
  $s = strcasecmp($a[0], $b[0]);
  return $s !== 0 ? $s : strcasecmp($a[1], $b[1]);
});

/* ===========================
   OUTPUT (COPY-PASTE FRIENDLY)
   =========================== */

// TSV (Excel / Google Sheets friendly)
echo "Sector\tApartment\n";
foreach ($rows as $r) {
  echo "{$r[0]}\t{$r[1]}\n";
}

// Markdown preview (optional)
echo "\n\n---- Markdown Preview ----\n";
echo "| Sector | Apartment |\n";
echo "|---|---|\n";
foreach ($rows as $r) {
  echo "| {$r[0]} | {$r[1]} |\n";
}
