<?php

header('Content-Type: text/plain'); // 伺服器告訴瀏覽器, 內容是純文字

$ar5 = [
  'Hello',
  'name' => 'Shinder',
  'age' => 29,
];
$ar6 = $ar5; # 設定值 (複製一份新的內容再設定)
$ar7 = &$ar5; # 設定位址, 同一個陣列

$ar5['name'] = 'John';

print_r($ar5);
print_r($ar6);
print_r($ar7);

$a = 10;
$b = &$a; # $a 和 $b 是相同的變數
$b = 25;

echo "\n  \$a = $a  \n\n";