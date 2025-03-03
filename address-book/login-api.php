<?php
require __DIR__ . "/parts/db-connect.php";

header('Content-Type: application/json');

$output = [
  'success' => false,
  'code' => 0, # 自己設定, 除錯用的
  'postData' => $_POST,
];

if (empty($_POST['email']) or empty($_POST['password'])) {
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

/*
1. 先確定帳號是對
2. 再確定密碼是不是對
3. 都對, 設定 session
*/
$sql = "SELECT * FROM members WHERE email=? ";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$row = $stmt->fetch();

if (empty($row)) {
  $output['code'] = 400; # 表示帳號錯誤
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

if (!password_verify($password, $row['password_hash'])) {
  $output['code'] = 420; # 表示密碼錯誤
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

# 把已登入的狀態設定到 session
$_SESSION['admin'] = [
  'member_id' => $row['member_id'],
  'email' => $row['email'],
  'nickname' => $row['nickname']
];

$output['success'] = true;
echo json_encode($output, JSON_UNESCAPED_UNICODE);
