<?php

// 在腳本最開始加入輸出緩衝
ob_start();

require __DIR__ . "/parts/admin-required.php"; # 需要管理者權限

require __DIR__ . "/parts/db-connect.php";

// 獲取要操作的資料表和 ID
$table = isset($_GET['table']) ? $_GET['table'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 安全性檢查
$allowed_tables = ['recipes', 'users', 'categories'];
if (!in_array($table, $allowed_tables) || $id <= 0) {
    header('Location: list-content-admin.php');
    exit;
}

// 獲取主鍵名稱
$stmt = $pdo->prepare("SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'");
$stmt->execute();
$primary_key = $stmt->fetch(PDO::FETCH_ASSOC)['Column_name'];

// 執行刪除
$stmt = $pdo->prepare("DELETE FROM {$table} WHERE {$primary_key} = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// 重定向回列表頁
header("Location: list-content-admin.php?table={$table}");
