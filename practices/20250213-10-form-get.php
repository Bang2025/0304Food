<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="" method="get">
    <input type="text" name="account" placeholder="帳號" /><br>
    <input type="password" name="password" placeholder="密碼" /><br>
    <input type="submit">
  </form>
  <div><?php echo $_GET['account'] ?? '' ?></div>
  <div><?= $_GET['password'] ?? '' ?></div>

</body>

</html>