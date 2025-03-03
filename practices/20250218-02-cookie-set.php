<?php
# 設定到要 response 給用戶端的檔頭
setcookie("my_cookie", "我的資料"); // 設定 cookie
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div>

    <?php
    # $_COOKIE: 讀取 request 送過來的 cookie
    $a = empty($_COOKIE['my_cookie']) ? '<h2>沒有 my_cookie 這個 cookie</h2>' : $_COOKIE['my_cookie'];
    echo $a;
    ?>
  </div>
</body>

</html>