<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    td {
      width: 50px;
      height: 50px;
    }
  </style>
</head>

<body>
  <table>
    <?php for ($i = 0; $i < 16; $i++): ?>
      <tr>
        <?php for ($k = 0; $k < 16; $k++): 
          $r = rand(0, 16777215); // 隨機取得顏色的數值 (十進位)
          ?>
          <td style="background-color: #<?= sprintf("%'06X", $r) ?>"></td>
        <?php endfor; ?>
      </tr>
    <?php endfor; ?>
  </table>
</body>

</html>