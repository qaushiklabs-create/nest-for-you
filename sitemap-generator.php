<?php
/**
 * FILE-STRUCTURE BASED SITEMAP GENERATOR
 * -------------------------------------
 * ✔ Converts /folder/index.php → /folder/
 * ✔ Converts /page.php → /page
 * ✔ Skips system folders
 * ✔ SEO-safe for Google Search Console
 *
 * Place in public_html, run once, then DELETE.
 */

$baseUrl = 'https://nestforyou.in'; // 🔴 CONFIRM DOMAIN
$rootDir = __DIR__;
$sitemapFile = $rootDir . '/sitemap.xml';

// Allowed extensions
$allowedExtensions = ['php', 'html', 'htm'];

// Skip folders
$skipDirs = [
  '.git', '.cpanel', '.trash', '.well-known',
  'vendor', 'node_modules', 'cache', 'tmp', 'logs'
];

// --------------------------------------------

function shouldSkipPath(string $path, array $skipDirs): bool {
  $path = str_replace('\\', '/', $path);
  foreach ($skipDirs as $skip) {
    if (preg_match('#(^|/)' . preg_quote($skip, '#') . '(/|$)#', $path)) {
      return true;
    }
  }
  return false;
}

$urls = [];

$iterator = new RecursiveIteratorIterator(
  new RecursiveDirectoryIterator($rootDir, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {

  if (!$file->isFile()) continue;

  $filePath = $file->getPathname();

  if (shouldSkipPath($filePath, $skipDirs)) continue;

  $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
  if (!in_array($ext, $allowedExtensions, true)) continue;

  // Build relative path
  $relativePath = str_replace($rootDir, '', $filePath);
  $relativePath = str_replace('\\', '/', $relativePath);

  // Handle index.php → folder URL
  if (basename($relativePath) === 'index.php') {
    $urlPath = rtrim(dirname($relativePath), '/') . '/';
  } else {
    $urlPath = str_replace('.php', '', $relativePath);
  }

  // Normalize URL
  $url = rtrim($baseUrl, '/') . $urlPath;

  $urls[$url] = [
    'loc' => $url,
    'lastmod' => date('Y-m-d', filemtime($filePath))
  ];
}

// --------------------------------------------
// GENERATE XML
// --------------------------------------------

$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;

$urlset = $xml->createElement('urlset');
$urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

foreach ($urls as $data) {
  $urlNode = $xml->createElement('url');
  $urlNode->appendChild($xml->createElement('loc', htmlspecialchars($data['loc'])));
  $urlNode->appendChild($xml->createElement('lastmod', $data['lastmod']));
  $urlset->appendChild($urlNode);
}

$xml->appendChild($urlset);
$xml->save($sitemapFile);

echo "<strong>Sitemap generated successfully!</strong><br>";
echo "Total URLs: " . count($urls) . "<br>";
echo "File: sitemap.xml";
