<?php
header('Content-Type: text/plain');


var_dump($a ?? '沒有 $a');
$a = NULL; # PHP 的 null 沒有區分大小寫
var_dump($a ?? 'no-$a');
$a = 0;
var_dump($a ?? 'no-$a');
$a = "";
var_dump($a ?? 'no-$a');
