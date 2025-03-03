<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>只讀取 cookie</h1>
  <div>

    <?php
    # $_COOKIE: 讀取 request 送過來的 cookie
    $a = empty($_COOKIE['my_cookie']) ? '<h2>沒有 my_cookie 這個 cookie</h2>' : $_COOKIE['my_cookie'];
    echo $a;
    ?>
  </div>
</body>

</html>