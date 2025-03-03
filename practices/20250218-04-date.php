<?php
# date_default_timezone_set('Asia/Taipei');
header('Content-Type: text/plain');

echo date('今年是 Y');
echo "\n\n";
echo date("Y-m-d H:i:s");
echo "\n\n";
echo date_default_timezone_get();  // 沒改設定檔的話, 預設應該是 Europe/Berlin

echo "\n\n";
$t = time(); # 取得當下的 timestamp (單位為秒)
$t += 30*24*60*60; // 30 天之後
echo date("Y-m-d H:i:s", $t);