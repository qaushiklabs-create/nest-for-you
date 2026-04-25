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

register_shutdown_function(function () {
  $err = error_get_last();
  if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
    respond(500, [
      'status'  => 'error',
      'message' => 'Server fatal error',
      'debug'   => $err['message'] ?? 'unknown'
    ]);
  }
});

function clean_text($v){
  $v = trim((string)$v);
  $v = preg_replace('/\s+/', ' ', $v);
  return $v;
}

function city_candidates($city){
  $city = clean_text($city);
  $out = [$city];

  if (strtolower($city) === "gurugram") $out[] = "Gurgaon";
  if (strtolower($city) === "gurgaon")  $out[] = "Gurugram";

  return array_values(array_unique(array_filter($out)));
}

/**
 * Normalize sector:
 * "sector1"/"Sector1"/"Sector 1"/"  sector  1 " => "Sector 1"
 * "1" => "Sector 1"
 */
function normalize_sector($s){
  $s = clean_text($s);
  if ($s === '') return '';

  $s = preg_replace('/[^a-zA-Z0-9\s]/', '', $s);
  $s = clean_text($s);

  if (preg_match('/^([0-9]+)$/', $s, $m)) {
    $n = (int)$m[1];
    if ($n <= 0) return '';
    return "Sector " . $n;
  }

  if (preg_match('/^sector\s*([0-9]+)$/i', $s, $m)) {
    $n = (int)$m[1];
    if ($n <= 0) return '';
    return "Sector " . $n;
  }

  $s = strtolower($s);
  $s = ucwords($s);
  if ($s === '0') return '';
  return $s;
}

function sector_key($s){
  $k = strtolower($s);
  $k = preg_replace('/\s+/', '', $k);
  return $k;
}

/** Extract numeric sector for sorting: "Sector 102" => 102 */
function sector_number($label){
  if (preg_match('/\b([0-9]+)\b/', (string)$label, $m)) {
    return (int)$m[1];
  }
  return PHP_INT_MAX; // non-numeric goes to bottom
}

/* ---------- request validation ---------- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(405, ['status' => 'error', 'message' => 'Invalid request method']);
}

$city = clean_text($_POST['city'] ?? '');
if ($city === '') respond(422, ['status' => 'error', 'message' => 'City is required']);

/* ---------- DB connect ---------- */
$servername = "localhost";
$username   = "nestforyou_user";
$password   = "YOUR_DB_PASSWORD";
$dbname     = "nestforyou_root";
$port       = 3306;

$conn = @new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
  respond(500, ['status' => 'error', 'message' => 'Database connection failed']);
}
$conn->set_charset("utf8mb4");

/* ---------- query ---------- */
$cityList = city_candidates($city);
if (empty($cityList)) {
  respond(422, ['status'=>'error','message'=>'Invalid city value']);
}

$cityPH = implode(',', array_fill(0, count($cityList), '?'));

$sql = "SELECT DISTINCT sector
        FROM forum
        WHERE city IN ($cityPH)
          AND sector IS NOT NULL
          AND TRIM(sector) <> ''";

$stmt = $conn->prepare($sql);
if (!$stmt) {
  respond(500, ['status' => 'error', 'message' => 'Query prepare failed']);
}

$types  = str_repeat('s', count($cityList));
$stmt->bind_param($types, ...$cityList);

$stmt->execute();
$result = $stmt->get_result();

/* ---------- build list + dedupe ---------- */
$out = [];
$seen = [];

while ($row = $result->fetch_assoc()) {
  $raw = clean_text($row['sector'] ?? '');
  if ($raw === '') continue;

  $norm = normalize_sector($raw);
  if ($norm === '') continue;

  $key = sector_key($norm);
  if (isset($seen[$key])) continue;
  $seen[$key] = true;

  $out[] = [
    'slug'  => $norm,
    'label' => $norm
  ];
}

$stmt->close();
$conn->close();

/* ✅ Numeric sort: Sector 1, Sector 2, ... Sector 10, ... Sector 102 */
usort($out, function($a, $b){
  $na = sector_number($a['label'] ?? '');
  $nb = sector_number($b['label'] ?? '');

  if ($na === $nb) {
    // tie-breaker (alphabetical)
    return strcmp((string)($a['label'] ?? ''), (string)($b['label'] ?? ''));
  }
  return $na <=> $nb;
});

respond(200, ['status' => 'success', 'data' => $out]);
