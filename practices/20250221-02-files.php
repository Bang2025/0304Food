<?php
header('Content-Type: application/json');

# 上傳的目標資料夾
$dir = __DIR__ . '/../images';


if (
  !empty($_FILES['avatar'])
  and
  is_string($_FILES['avatar']['name'])
) {
  $fn = mb_strtolower($_FILES['avatar']['name']); # 原本的檔名
  $fn_ar = explode('.', $fn);
  $ext = end($fn_ar); # 最後一段是副檔名
  $new_fn = sha1($fn . uniqid()) . "." . $ext;

  $uploaded_avatar = move_uploaded_file(
    $_FILES['avatar']['tmp_name'],
    $dir . "/" . $new_fn
  );
}


echo json_encode([
  'filename' => $new_fn,
  '$uploaded_avatar' => $uploaded_avatar,
  '$_FILES' => $_FILES,
  '$_POST' => $_POST,
]);
