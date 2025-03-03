<?php
header('Content-Type: application/json');

session_start(); # 啟用 session 的功能

if (! isset($_SESSION['num'])) {
  $_SESSION['num'] = 0;
}

$_SESSION['num']++;

echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);
