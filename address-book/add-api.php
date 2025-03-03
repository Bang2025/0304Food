<?php
require __DIR__ . "/parts/admin-required.php"; # 需要管理者權限
require __DIR__ . "/parts/db-connect.php";

header('Content-Type: application/json');

$output = [
  'success' => false,
  'postData' => $_POST,
  'error' => '',
  'errorFields' => []
];


/*
# 會有 SQL injection 的漏洞
$sql = "INSERT INTO `address_book` (
  `name`, `email`, `mobile`, `birthday`, `address`
  ) VALUES (
    '{$_POST['name']}',
    '{$_POST['email']}',
    '{$_POST['mobile']}',
    '{$_POST['birthday']}',
    '{$_POST['address']}'
  )";

try {
  $stmt = $pdo->query($sql);
  # $stmt->rowCount() 影響的列數, 新增的話就是新增幾筆
  $output['success'] = !! $stmt->rowCount();
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}
  */

# 欄位的資料檢查
$title = trim($_POST['title'] ?? '');
$servings = mb_strtolower(trim($_POST['servings'] ?? '')); # 去掉頭尾空白, 轉成小寫字母

$isPass = true;

if (empty($title)) {
  $isPass = false;
  $output['errorFields']['title'] = '食譜名為必填欄位';
} elseif (mb_strlen($title) < 2) {
  $isPass = false;
  $output['errorFields']['title'] = '請填寫正確的食譜名';
}

if (empty($servings)) {
  $isPass = false;
  $output['errorFields']['servings'] = 'servings 為必填欄位';
} elseif (!ctype_digit($servings)) {
  $isPass = false;
  $output['errorFields']['servings'] = '請填寫正確的 servings 格式';
}

if(! $isPass) {
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

# 處理日期的格式
$birthday = null;
if (!empty($_POST['birthday'])) {
  $t = strtotime($_POST['birthday']); # 整數(timestamp) 或 false
  if ($t !== false) {
    $birthday = date('Y-m-d', $t);
  }
}

$sql = "INSERT INTO `recipes` (
    `title`, `servings`, `description`, `view_count`, `like_count`
    ) VALUES (
      ?,
      ?,
      ?,
      ?,
      ?
    )";
try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $title,
    $servings,
    $_POST['description'],
    $_POST['view_count'],
    $_POST['like_count'],
  ]);

  # $stmt->rowCount() 影響的列數, 新增的話就是新增幾筆
  $output['success'] = !! $stmt->rowCount();
  $output['id'] = $pdo->lastInsertId(); # 最近新增資料的 PK
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
