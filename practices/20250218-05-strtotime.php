<?php

header('Content-Type: text/plain');

$t1 = strtotime('2024-02-29'); # 日期時間的字串轉換成 timestamp
$t2 = strtotime('2024/02/29');
$t3 = strtotime('2025/02/29');
$t4 = strtotime('2025/02/32'); # false, 表示不合法的日期格式


# echo date("Y-m-d H:i:s");
var_dump($t1);
echo '$t1:'. date("Y-m-d", $t1). "\n\n";
var_dump($t2);
echo '$t2:'. date("Y-m-d", $t2). "\n\n";
var_dump($t3);
echo '$t3:'. date("Y-m-d", $t3). "\n\n";
var_dump($t4);
echo '$t4:'. date("Y-m-d", $t4). "\n\n";

