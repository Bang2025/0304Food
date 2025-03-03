<?php
header('Content-Type: text/plain');

# echo true;  # true 輸出到頁面會被轉換為 '1'
# echo false;  # true 輸出到頁面會被轉換為 '' (空字串)

# var_dump() 除錯時, 查看值的類型和內容
var_dump( 5 && 7 );  
var_dump( 5 || 7 );
echo "-----------\n";
var_dump( !7 );
var_dump( !!7 );
echo "-----------\n";

$a = 7 and 5; # 相當於 ($a = 7) and 5;
var_dump( $a );

$b = (7 and 5);
var_dump( $b );
