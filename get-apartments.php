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
function to_slug($v){
  $v = strtolower(trim((string)$v));
  $v = preg_replace('/[^a-z0-9\s\-]/', '', $v);
  $v = preg_replace('/\s+/', '-', $v);
  $v = preg_replace('/\-+/', '-', $v);
  return trim($v, '-');
}
function to_label($v){
  $v = clean_text($v);
  $v = strtolower($v);
  return ucwords($v);
}
function sector_candidates($sector){
  $sector = clean_text($sector);
  $out = [$sector];

  if (preg_match('/^sector\s*([0-9]+)$/i', $sector, $m)) {
    $num = $m[1];
    $out[] = "Sector " . $num;
    $out[] = $num;
  }
  if (preg_match('/^sector\s+([0-9]+)$/i', $sector, $m)) {
    $num = $m[1];
    $out[] = "sector" . $num;
    $out[] = $num;
  }
  if (preg_match('/^([0-9]+)$/', $sector, $m)) {
    $num = $m[1];
    $out[] = "sector" . $num;
    $out[] = "Sector " . $num;
  }

  return array_values(array_unique(array_filter($out)));
}
function city_candidates($city){
  $city = clean_text($city);
  $out = [$city];

  if (strtolower($city) === "gurugram") $out[] = "Gurgaon";
  if (strtolower($city) === "gurgaon")  $out[] = "Gurugram";

  return array_values(array_unique(array_filter($out)));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(405, ['status' => 'error', 'message' => 'Invalid request method']);
}

$city   = clean_text($_POST['city'] ?? '');
$sector = clean_text($_POST['sector'] ?? '');

if ($city === '')   respond(422, ['status' => 'error', 'message' => 'City is required']);
if ($sector === '') respond(422, ['status' => 'error', 'message' => 'Sector is required']);

$servername = "localhost";
$username   = "nestforyou_user";
$password   = "Nestforyou@2025";
$dbname     = "nestforyou_root";
$port       = 3306;

$conn = @new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
  respond(500, ['status' => 'error', 'message' => 'Database connection failed']);
}
$conn->set_charset("utf8mb4");

$cityList   = city_candidates($city);
$sectorList = sector_candidates($sector);

if (empty($cityList) || empty($sectorList)) {
  respond(422, ['status'=>'error','message'=>'Invalid city/sector values']);
}

$cityPH   = implode(',', array_fill(0, count($cityList), '?'));
$sectorPH = implode(',', array_fill(0, count($sectorList), '?'));

$sql = "SELECT DISTINCT apartment
        FROM forum
        WHERE city IN ($cityPH)
          AND sector IN ($sectorPH)
          AND apartment IS NOT NULL
          AND TRIM(apartment) <> ''
        ORDER BY apartment ASC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
  respond(500, ['status' => 'error', 'message' => 'Query prepare failed']);
}

$types  = str_repeat('s', count($cityList) + count($sectorList));
$params = array_merge($cityList, $sectorList);
$stmt->bind_param($types, ...$params);

$stmt->execute();
$result = $stmt->get_result();

$out = [];
while ($row = $result->fetch_assoc()) {
  $apt = clean_text($row['apartment'] ?? '');
  if ($apt === '') continue;

  $out[] = [
    'slug'  => to_slug($apt),
    'label' => to_label($apt)
  ];
}

$stmt->close();
$conn->close();

respond(200, ['status' => 'success', 'data' => $out]);
