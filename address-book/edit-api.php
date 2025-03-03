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



# 欄位的資料檢查
$recipe_id = isset($_POST['recipe_id']) ? intval($_POST['recipe_id']) : 0;
$title = trim($_POST['title'] ?? '');
$servings = mb_strtolower(trim($_POST['servings'] ?? '')); # 去掉頭尾空白, 轉成小寫字母

$isPass = true;

if (empty($title)) {
  $isPass = false;
  $output['errorFields']['title'] = '姓名為必填欄位';
} elseif (mb_strlen($title) < 2) {
  $isPass = false;
  $output['errorFields']['title'] = '請填寫正確的姓名';
}

if (empty($servings)) {
  $isPass = false;
  $output['errorFields']['servings'] = 'servings 為必填欄位';
} elseif (!ctype_digit($servings)) {
  $isPass = false;
  $output['errorFields']['servings'] = '請填寫正確的 servings 格式';
}

if (! $isPass) {
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

$sql = "UPDATE `recipes` SET 
    `title`=?,
    `servings`=?,
    `description`=?,
    `view_count`=?,
    `like_count`=?
    WHERE `recipe_id`=? ";
try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $title,
    $servings,
    $_POST['description'],
    $_POST['view_count'],
    $_POST['like_count'],
    $recipe_id
  ]);

  # $stmt->rowCount() 影響的列數, 如果修改的資料和原本資料一樣, 會拿到 false
  $output['success'] = !! $stmt->rowCount();
} catch (PDOException $ex) {
  $output['error'] = $ex->getMessage();
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
