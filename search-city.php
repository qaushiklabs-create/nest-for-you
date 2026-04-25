<?php
ob_start();
header('Content-Type: application/json; charset=utf-8');

error_reporting(0);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

function respond(int $code, array $payload) {
  if (ob_get_length()) { ob_clean(); }
  http_response_code($code);
  echo json_encode($payload, JSON_UNESCAPED_UNICODE);
  exit;
}

/**
 * ✅ Catch fatal errors and still return JSON
 */
register_shutdown_function(function () {
  $err = error_get_last();
  if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
    respond(500, [
      'status' => 'error',
      'message' => 'Server fatal error',
      'debug' => $err['message'] ?? 'unknown'
    ]);
  }
});

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(405, ['status' => 'error', 'message' => 'Invalid request method']);
}

$city   = trim($_POST['city'] ?? '');
$sector = trim($_POST['sector'] ?? '');
$apartment = trim($_POST['apartment'] ?? '');

// ----------------------------
// Extract sector number safely
// ----------------------------
function extract_sector_number($v){
  $v = strtolower(trim($v));

  // sector3 / sector-3 / sector 3 / sector03
  if (preg_match('/sector[\s\-]*0*(\d+)/', $v, $m)) {
    return (int)$m[1];
  }

  return null;
}

$sectorNumber = extract_sector_number($sector);

// ----------------------------
// Normalization helpers
// ----------------------------
function normalize_city($v){
  $v = trim($v);
  if ($v === '') return $v;

  $l = strtolower($v);
  if ($l === 'gurgaon' || $l === 'gurugram') {
    return 'Gurugram';
  }

  return ucfirst(strtolower($v));
}

// Apply normalization
$city   = normalize_city($city);

function normalize_apartment($v){
  $v = trim($v);
  if ($v === '') return '';

  // bharat-residency-apartment → Bharat Residency Apartment
  if (strpos($v, '-') !== false) {
    $v = str_replace('-', ' ', $v);
  }

  return ucwords(strtolower($v));
}

$apartment = normalize_apartment($apartment);

// 🔍 DEBUG
error_log("SEARCH DEBUG → city={$city}, sector={$sector}, apartment={$apartment}");

if ($city === '')   respond(422, ['status' => 'error', 'message' => 'City is required']);
if ($sector === '') respond(422, ['status' => 'error', 'message' => 'Sector is required']);
if ($sectorNumber === null) {
  respond(422, ['status' => 'error', 'message' => 'Invalid sector format']);
}

$servername = "localhost";
$username   = "nestforyou_user";
$password   = "YOUR_DB_PASSWORD";
$dbname     = "nestforyou_root";
$port       = 3306;

$conn = @new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
  respond(500, ['status' => 'error', 'message' => 'Database connection failed']);
}

$sql = "
SELECT name, email, phone_number, city
FROM forum
WHERE LOWER(city) IN ('gurgaon','gurugram')
AND CAST(REGEXP_REPLACE(sector, '[^0-9]', '') AS UNSIGNED) = ?
ORDER BY created_at DESC
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
  respond(500, ['status' => 'error', 'message' => 'Query prepare failed']);
}

$stmt->bind_param("i", $sectorNumber);

$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
  // ✅ return only the fields you want
  $data[] = [
    'name' => $row['name'] ?? '',
    'city' => $row['city'] ?? '',
    'phone_number' => $row['phone_number'] ?? '',
    'email' => $row['email'] ?? ''
  ];
}

$stmt->close();
$conn->close();

if (!empty($data)) {
  respond(200, ['status' => 'success', 'data' => $data]);
}

respond(200, ['status' => 'empty', 'message' => 'No clients found']);
