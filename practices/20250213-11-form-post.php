<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="" method="post">
    <input type="text" name="account" placeholder="帳號" /><br>
    <input type="password" name="password" placeholder="密碼" /><br>
    <input type="submit">
  </form>
  <div><?= isset($_POST['account']) ? $_POST['account'] : '' ?></div>
  <div><?= $_POST['password'] ?? '' ?></div>

</body>

</html>