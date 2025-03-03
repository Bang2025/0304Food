<?php

header('Content-Type: text/plain'); // 伺服器告訴瀏覽器, 內容是純文字


$ar = []; // 說明的用途

for ($i = 1; $i <= 42; $i++) {
  $ar[] = $i; // array push
}
shuffle($ar); // 隨機排序

# print_r($ar);
echo implode('-', $ar); // 陣列接成字串
echo "\n\n";

$str = '恭::喜::發::財';

$ar2 = explode('::', $str); // 切割字串變成陣列

print_r($ar2);