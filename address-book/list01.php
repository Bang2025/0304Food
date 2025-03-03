<?php
header('Content-Type: application/json');
require __DIR__ . "/parts/db-connect.php";


$sql = "SELECT * FROM recipes ORDER BY recipe_id DESC LIMIT 3";

$stmt = $pdo->query($sql); # 取得代理的物件

$row = $stmt->fetch(); # 讀取一筆, 預設會給兩種資料 [索引式] 加 [關聯式]
# $row = $stmt->fetch(PDO::FETCH_ASSOC); # 只取 [關聯式]
# $row = $stmt->fetch(PDO::FETCH_NUM); # 只取 [索引式]

$rows = $stmt->fetchAll(); # 讀取剩餘的全部

echo json_encode([
  '$row' => $row,
  '$rows' => $rows,
], JSON_UNESCAPED_UNICODE);
