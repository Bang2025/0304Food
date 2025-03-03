<?php

header('Content-Type: application/json');

# sleep(10); # 暫停幾秒

echo json_encode([
  'query_string' => $_GET,
  'form_data' => $_POST,
], JSON_PRETTY_PRINT);
