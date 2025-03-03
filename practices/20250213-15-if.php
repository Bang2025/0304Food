<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  $age = !empty($_GET['age']) ? intval($_GET['age']) : 0;
  if ($age >= 18) {
  ?>
    <h1>歡迎光臨</h1>
    <img width="300" src="https://images.squarespace-cdn.com/content/v1/54822a56e4b0b30bd821480c/29708160-9b39-42d0-a5ed-4f8b9c85a267/labrador+retriever+dans+pet+care.jpeg" alt="">
  <?php
  } else {
  ?>
    <h1>請勿進入</h1>
    <img width="300" src="https://cdn.outsideonline.com/wp-content/uploads/2023/03/Funny_Dog_S.jpg" alt="">
  <?php
  }
  ?>
</body>

</html>