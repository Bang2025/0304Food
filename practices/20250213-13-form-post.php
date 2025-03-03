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
    <input type="submit" value="送出表單">
    <br><br>
    <!-- 表單裡的 button, 沒有設定 type 時, 預設值是 submit -->
    <button>按鈕 1</button>
    <br><br>
    <button type="button" onclick="togglePassword()">切換密碼顯示</button>
  </form>
  <br><br>
  <button>按鈕 2</button>
  <div><?= isset($_POST['account']) ? $_POST['account'] : '' ?></div>
  <div><?= $_POST['password'] ?? '' ?></div>
  <script>
    const togglePassword = () => {
      // 密碼欄
      const p = document.forms[0].password;
      /*
      if (p.getAttribute('type') == 'password') {
        p.setAttribute('type', 'text'); // 變成一般文字輸入欄
      } else {
        p.setAttribute('type', 'password'); // 變成密碼欄
      }
      */
      // 可讀性不佳
      p.setAttribute('type', p.getAttribute('type') == 'password' ? 'text' : 'password');
    }
  </script>
</body>

</html>