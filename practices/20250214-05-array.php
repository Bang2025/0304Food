<?php

header('Content-Type: text/plain'); // 伺服器告訴瀏覽器, 內容是純文字

$ar1 = array(2, 3, 4);
$ar2 = [2, 3, 4];

print_r($ar2); // print_r() 開發時, 查看陣列內容
var_dump($ar2);
echo "\n";
$ar3 = array(
  'name' => 'Shinder',
  'age' => 29,
);
$ar4 = [
  'name' => 'Shinder',
  'age' => 29,
];
print_r($ar4);
echo "\n";

$ar5 = [
  'Hello',
  'name' => 'Shinder',
  'age' => 29,
  '您好'
];
print_r($ar5);