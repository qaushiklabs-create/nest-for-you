<?php
/**
 * WARNING: Backup your site before running this script.
 *
 * This script scans files under the folder where it is placed (usually public_html)
 * and REMOVES any  blocks including content between them.
 *
 * Place this file in public_html, run once, then DELETE it.
 */

$rootDir = __DIR__;

// Only scan safe text-based extensions
$allowedExtensions = [
  'php','html','htm','css','js','txt','json','xml','md'
];

// Skip heavy/system folders (edit if needed)
$skipDirs = [
  '.git', '.well-known', 'vendor', 'node_modules',
  'cache', 'tmp', 'logs', '.cpanel', '.trash'
];

function shouldSkipPath(string $path, array $skipDirs): bool {
  $path = str_replace('\\', '/', $path);
  foreach ($skipDirs as $skip) {
    if (preg_match('#(^|/)' . preg_quote($skip, '#') . '(/|$)#', $path)) {
      return true;
    }
  }
  return false;
}

function scanAndRemoveIframes(
  string $dir,
  array $allowedExtensions,
  array $skipDirs
): void {

  $iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
  );

  // Regex to remove:  (non-greedy, multiline, case-insensitive)
  $iframePattern = '#<iframe\b[^>]*>.*?</iframe\s*>#is';

  foreach ($iterator as $file) {
    $filePath = $file->getPathname();

    // Skip unwanted directories/files
    if (shouldSkipPath($filePath, $skipDirs)) continue;
    if (!$file->isFile()) continue;

    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions, true)) continue;

    $content = @file_get_contents($filePath);
    if ($content === false) continue;

    $updated = $content;

    // Count and remove all iframes
    $count = 0;
    $updated = preg_replace_callback($iframePattern, function ($matches) use (&$count) {
      $count++;
      return '';
    }, $updated);

    // Write only if changes were made
    if ($count > 0 && $updated !== null && $updated !== $content) {
      if (@file_put_contents($filePath, $updated) !== false) {
        echo "Updated: " . htmlspecialchars($filePath) . " (Removed iframes: {$count})<br>";
      } else {
        echo "FAILED: " . htmlspecialchars($filePath) . "<br>";
      }
    }
  }
}

// Run
scanAndRemoveIframes($rootDir, $allowedExtensions, $skipDirs);

echo "<br><strong>Iframe removal completed successfully.</strong>";
