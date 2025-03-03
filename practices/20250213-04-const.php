<?php
# 傳統的常數定義方式 
define("MY_CONST_1", 345);

# 新的常數定義方式
const MY_CONST_2 = 12.34;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  echo MY_CONST_1. '<br>';
  echo MY_CONST_2. '<br>';
  # MY_CONST_2 = 3; # 發生錯誤, 不可變更常數
  ?>
</body>

</html>