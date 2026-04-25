<?php
header("Content-Type: text/plain; charset=utf-8");

/**
 * We try multiple base paths and pick the first valid one.
 * This removes DOCUMENT_ROOT confusion on cPanel setups.
 */
$candidates = [
  // ✅ Best: script is in public_html, so use __DIR__
  __DIR__ . "/contact/real-estate-agents/gurgaon",

  // Backup: sometimes DOCUMENT_ROOT works
  ($_SERVER['DOCUMENT_ROOT'] ?? "") . "/contact/real-estate-agents/gurgaon",

  // Backup: if script is moved into a subfolder accidentally
  dirname(__DIR__) . "/public_html/contact/real-estate-agents/gurgaon",
];

$baseDir = null;
foreach ($candidates as $p) {
  $rp = realpath($p);
  if ($rp && is_dir($rp)) { $baseDir = $rp; break; }
}

// ✅ Print debug info so you can SEE what it is using
echo "DEBUG\n";
echo "-----\n";
echo "__DIR__              : " . __DIR__ . "\n";
echo "DOCUMENT_ROOT        : " . ($_SERVER['DOCUMENT_ROOT'] ?? "(not set)") . "\n";
echo "Resolved baseDir      : " . ($baseDir ?: "(NOT FOUND)") . "\n";
echo "Tried candidates:\n";
foreach ($candidates as $p) {
  echo " - $p  => " . (is_dir($p) ? "DIR" : "no") . "  | realpath: " . (realpath($p) ?: "-") . "\n";
}
echo "\n\n";

if (!$baseDir) {
  echo "ERROR: Could not find target folder.\n";
  echo "Fix: confirm folder exists at public_html/contact/real-estate-agents/gurgaon\n";
  exit;
}

// ---------------- SETTINGS ----------------

// Exclude these filenames anywhere
$excludeFilesExact = [
  ".", "..",
  "error_log", ".htaccess", "index.php", "index.html",
  "get-apartments.php"
];

// Exclude files by extension
$excludeExtensions = ["log", "txt"];

// Only include apartment pages with these extensions
$includeExtensions = ["php", "html", "htm"];

// Remove extension from apartment name
$removeExtensionInName = true;

// Exclude files starting with "_"
$excludeUnderscorePrefix = true;

function ext_of($filename) {
  $pos = strrpos($filename, ".");
  return ($pos === false) ? "" : strtolower(substr($filename, $pos + 1));
}

// Collect rows: [Sector, Apartment]
$rows = [];

$dirs = @scandir($baseDir);
if ($dirs === false) {
  echo "ERROR: Unable to scan directory: $baseDir\n";
  exit;
}

foreach ($dirs as $sectorFolder) {
  if ($sectorFolder === "." || $sectorFolder === "..") continue;
  if (strpos($sectorFolder, ".") === 0) continue;

  $sectorPath = $baseDir . DIRECTORY_SEPARATOR . $sectorFolder;
  if (!is_dir($sectorPath)) continue;

  $files = @scandir($sectorPath);
  if ($files === false) continue;

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

// Sort by Sector then Apartment
usort($rows, function($a, $b){
  $s = strcasecmp($a[0], $b[0]);
  return $s !== 0 ? $s : strcasecmp($a[1], $b[1]);
});

// ---- OUTPUT: TSV (best for copy/paste to Sheets/Excel) ----
echo "Sector\tApartment\n";
foreach ($rows as $r) {
  echo "{$r[0]}\t{$r[1]}\n";
}
