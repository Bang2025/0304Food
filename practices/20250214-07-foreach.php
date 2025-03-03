<?php

header('Content-Type: text/plain'); // 伺服器告訴瀏覽器, 內容是純文字

$ar5 = [
  'Hello',
  'name' => 'Shinder',
  'age' => 29,
  '您好'
];
$ar6 = $ar5; # 設定值 (複製一份新的內容再設定)

// 很少這樣用
while ($v = array_pop($ar5)) {
  echo "$v \n";
}
echo "\n\n";

// 只取 value
foreach($ar6 as $v){
  echo "$v \n";
}
echo "\n\n";
// 取 key 及 value
foreach($ar6 as $k => $v){
  echo "$k: $v, $ar6[$k] \n";
}
echo "\n\n";
echo "{$ar6['name']} \n"; // 需要大括號包裹