<?php
// IMPORTANT: no blank lines/spaces before this tag

ob_start();
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Kolkata');

ini_set('display_errors', '0');
ini_set('log_errors', '1');

function respond(int $code, array $payload): void {
  if (ob_get_length()) { ob_clean(); }
  http_response_code($code);
  echo json_encode($payload, JSON_UNESCAPED_UNICODE);
  exit;
}

function log_line(string $line): void {
  // cPanel-safe log location
  $file = __DIR__ . '/store_data_debug.log';
  @file_put_contents($file, "[" . date('Y-m-d H:i:s') . "] " . $line . PHP_EOL, FILE_APPEND);
}

/* ---------- GET = health check ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  respond(200, [
    'status' => 'ok',
    'message' => 'store_data.php reachable',
    'file' => __FILE__,
    'dir'  => __DIR__
  ]);
}

/* ---------- POST only ---------- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(405, ['status' => 'error', 'message' => 'Method not allowed. Use POST.']);
}

/* ---------- DB ---------- */
$servername = "localhost";
$username   = "nestforyou_user";
$password   = "Nestforyou@2025";
$dbname     = "nestforyou_root";
$port       = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
  log_line("DB connect error: " . $conn->connect_error);
  respond(500, ['status' => 'error', 'message' => 'DB connection failed', 'detail' => $conn->connect_error]);
}

/* confirm actual selected DB */
$dbRow = $conn->query("SELECT DATABASE() AS db")->fetch_assoc();
$actualDb = $dbRow['db'] ?? '(unknown)';

/* ---------- Inputs ---------- */
$name         = trim($_POST['name'] ?? '');
$email        = trim($_POST['email'] ?? '');
$phone_number = trim($_POST['phone_number'] ?? '');
$city         = trim($_POST['city'] ?? '');
$sector       = trim($_POST['sector'] ?? '');
$ip           = $_SERVER['REMOTE_ADDR'] ?? '';
$dt           = date('Y-m-d H:i:s');

log_line("POST received: name={$name} email={$email} phone={$phone_number} city={$city} sector={$sector} ip={$ip}");

if ($name === '' || $email === '' || $phone_number === '' || $city === '' || $sector === '') {
  respond(422, ['status' => 'error', 'message' => 'All fields are required.']);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  respond(422, ['status' => 'error', 'message' => 'Invalid email address.']);
}

$message = "Lead from website | City: {$city} | Sector: {$sector}";

/* ---------- Make sure table exists in THIS DB ---------- */
$chk = $conn->query("SHOW TABLES LIKE 'forum'");
if (!$chk || $chk->num_rows === 0) {
  log_line("Table forum not found in DB: {$actualDb}");
  respond(500, [
    'status' => 'error',
    'message' => "Table 'forum' not found in database: {$actualDb}",
    'db' => $actualDb
  ]);
}

/* ---------- Try inserts depending on your forum columns ---------- */
$attempts = [
  [
    "label" => "with_sector_with_updated",
    "sql" => "INSERT INTO forum (name,email,phone_number,city,sector,message,ip,created_at,updated_at)
             VALUES (?,?,?,?,?,?,?,?,?)",
    "types" => "sssssssss",
    "params" => [$name,$email,$phone_number,$city,$sector,$message,$ip,$dt,$dt]
  ],
  [
    "label" => "no_sector_with_updated",
    "sql" => "INSERT INTO forum (name,email,phone_number,city,message,ip,created_at,updated_at)
             VALUES (?,?,?,?,?,?,?,?)",
    "types" => "ssssssss",
    "params" => [$name,$email,$phone_number,$city,$message,$ip,$dt,$dt]
  ],
  [
    "label" => "with_sector_no_updated",
    "sql" => "INSERT INTO forum (name,email,phone_number,city,sector,message,ip,created_at)
             VALUES (?,?,?,?,?,?,?,?)",
    "types" => "ssssssss",
    "params" => [$name,$email,$phone_number,$city,$sector,$message,$ip,$dt]
  ],
  [
    "label" => "minimal",
    "sql" => "INSERT INTO forum (name,email,phone_number,city,message)
             VALUES (?,?,?,?,?)",
    "types" => "sssss",
    "params" => [$name,$email,$phone_number,$city,$message]
  ],
];

$lastError = "";
$lastLabel = "";

foreach ($attempts as $try) {
  $lastLabel = $try["label"];
  $stmt = $conn->prepare($try["sql"]);
  if (!$stmt) {
    $lastError = "Prepare failed ({$lastLabel}): " . $conn->error;
    log_line($lastError);
    continue;
  }

  $types  = $try["types"];
  $params = $try["params"];

  $bind = [];
  $bind[] = $types;
  for ($i=0; $i<count($params); $i++) $bind[] = &$params[$i];

  call_user_func_array([$stmt, 'bind_param'], $bind);

  if ($stmt->execute()) {
    $insertId = $stmt->insert_id;
    log_line("INSERT OK ({$lastLabel}) insert_id={$insertId} db={$actualDb}");

    respond(200, [
      'status' => 'success',
      'message' => 'Your message has been successfully submitted.',
      'db' => $actualDb,
      'table' => 'forum',
      'insert_id' => $insertId,
      'attempt' => $lastLabel
    ]);
  } else {
    $lastError = "Execute failed ({$lastLabel}): " . $stmt->error;
    log_line($lastError);
  }
}

respond(500, [
  'status' => 'error',
  'message' => 'Insert failed. Table columns do not match.',
  'db' => $actualDb,
  'attempt' => $lastLabel,
  'detail' => $lastError
]);
