<?php

header('Content-Type: application/json');

$ar5 = [
  'Hello',
  'name' => '小新',
  'age' => 29,
];

# echo json_encode($ar5, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
echo json_encode($ar5, JSON_UNESCAPED_UNICODE);
