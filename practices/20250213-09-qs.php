<?php
// Query String Parameters 

# echo $_GET['a']; # 輸出 QS 的 a 的參數
$a = isset($_GET['a']) ? intval($_GET['a']) : 0;

echo $a;