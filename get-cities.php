<?php
header('Content-Type: application/json');

$cities = [
  "Delhi",
  "Noida",
  "Gurgaon",
  "Faridabad"
];

sort($cities, SORT_STRING | SORT_FLAG_CASE);

echo json_encode([
  "status" => "success",
  "data"   => $cities
]);
exit;
