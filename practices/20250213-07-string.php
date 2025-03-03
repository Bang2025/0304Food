<?php
header('Content-Type: text/plain'); // 伺服器告訴瀏覽器, 內容是純文字
# header('Content-Type: text/html'); // html 內容


$name = "小明";

echo " $name 您好 <hr> \n";
echo ' $name 您好 \n';
echo "\n\n";
echo " {$name}2 您好 \n";