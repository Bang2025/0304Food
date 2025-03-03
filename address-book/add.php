<?php

// ob_start()功能為輸出緩衝。通常要放在最上面 
// 。 輸出緩衝會收集所有通常會立即發送到瀏覽器的輸出，並保留它直到腳本執行完成或直到你刷新緩衝區，這樣你就可以在腳本的任何位置發送標頭。
ob_start();

require __DIR__ . "/parts/admin-required.php"; # 需要管理者權限
require __DIR__ . "/parts/db-connect.php";
$title = '新增通訊錄';
$pageName = 'ab-add';
?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<style>
  form .form-text {
    color: red;
  }
</style>
<?php include __DIR__ . '/parts/html-navbar.php' ?>
<?php
// add.php
// $db_host = 'localhost';
// $db_user = 'username';
// $db_pass = 'password';
// $db_name = 'database_name';
// $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

// 獲取要操作的資料表
$table = isset($_GET['table']) ? $_GET['table'] : '';

// 安全性檢查 - 擴展允許訪問的表格列表
$allowed_tables = [
  'carts',
  'categories',
  'chatmessages',
  'contactus',
  'food_products',
  'ingredients',
  'members',
  'orders',
  'order_items',
  'product_reviews',
  'qanda',
  'recipes',
  'recipe_categories',
  'recipe_images',
  'recipe_tags',
  'steps',
  'tags',
  'users'
];


if (!in_array($table, $allowed_tables)) {
    header('Location: list-content-admin.php');
    exit;
}

// 獲取表格結構
$stmt = $pdo->prepare("DESCRIBE {$table}"); //DESCRIBE 語句在 MySQL 中用於獲取表格的結構，包括欄位名稱、資料類型、是否允許 NULL 值等。
$stmt->execute();
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 獲取主鍵名稱
$stmt = $pdo->prepare("SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'");
$stmt->execute();
$primary_key_data = $stmt->fetch(PDO::FETCH_ASSOC);
$primary_key = $primary_key_data ? $primary_key_data['Column_name'] : null;

// 如果是表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // 創建一個欄位名稱的索引數組，方便後續檢查
    $column_names = array_column($columns, 'Field');

// 特殊處理



    // 構建 SQL 插入語句
    $insert_fields = [];
    $insert_values = [];
    $params = [];

    foreach ($columns as $col) {
        $column_name = $col['Field'];
        //要跳過或是自動設定的

        // 跳過自動增長的主鍵
        if ($column_name == $primary_key && strpos($col['Extra'], 'auto_increment') !== false) {
            continue;
        }

         // 對於 created_at 和 updated_at 欄位，自動設定為當前時間
            if ($column_name == 'created_at' || $column_name == 'updated_at') {
               $insert_fields[] = $column_name;
               $insert_values[] = "NOW()";  // 使用 MySQL 的 NOW() 函數
                continue;  // 跳過後續處理
              }

        
        if (isset($_POST[$column_name])) {
            $insert_fields[] = $column_name;
            $insert_values[] = ":{$column_name}";
            $params[":{$column_name}"] = $_POST[$column_name] ?:null;  //這邊的意思
        }
    }

          // 如果表格有這些欄位但尚未添加（可能因為它們沒有出現在 $_POST 中）
      if (!in_array('created_at', $insert_fields) && in_array('created_at', $column_names)) {
        $insert_fields[] = 'created_at';
        $insert_values[] = "NOW()";
      }

      if (!in_array('updated_at', $insert_fields) && in_array('updated_at', $column_names)) {
        $insert_fields[] = 'updated_at';
        $insert_values[] = "NOW()";
      }


    $sql = "INSERT INTO {$table} (" . implode(', ', $insert_fields) . ") VALUES (" . implode(', ', $insert_values) . ")";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header("Location: list-content-admin.php?table={$table}");
    exit;
}

// 定義不同資料表的頁面標題
$table_titles = [
  'recipes' => '食譜管理',
  'users' => '用戶管理',
  'categories' => '分類管理',
  'carts' => '購物車管理',
  'chatmessages' => '聊天訊息管理',
  'contactus' => '聯絡我們管理',
  'food_products' => '食品產品管理',
  'ingredients' => '原料管理',
  'members' => '會員管理',
  'orders' => '訂單管理',
  'order_items' => '訂單項目管理',
  'product_reviews' => '產品評論管理',
  'qanda' => '問答管理',
  'recipe_categories' => '食譜分類管理',
  'recipe_images' => '食譜圖片管理',
  'recipe_tags' => '食譜標籤管理',
  'steps' => '步驟管理',
  'tags' => '標籤管理'
];


// 當前表格的標題
$page_title = isset($table_titles[$table]) ? $table_titles[$table] : '新增資料';
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4"><?= $page_title ?></h1>
        
        <form method="POST">
            <?php foreach ($columns as $col): ?>
                <?php $column_name = $col['Field']; ?>
                <?php 
                //要跳過或忽略的幾乎都會放這邊
                // 跳過自動增長的主鍵以及 created_at 和 updated_at 欄位
                    if (($column_name == $primary_key && strpos($col['Extra'], 'auto_increment') !== false) || 
                    $column_name == 'created_at' || $column_name == 'updated_at') {
                    continue;
                      }

                
                ?>
                <div class="mb-3">
                    <label for="<?= $column_name ?>" class="form-label"><?= htmlspecialchars($column_name) ?></label>
                    
                    <?php if (stripos($col['Type'], 'text') !== false): ?>
                        <textarea class="form-control" id="<?= $column_name ?>" name="<?= $column_name ?>" rows="4"></textarea>
                    <?php elseif (stripos($col['Type'], 'date') !== false): ?>
                        <input type="date" class="form-control" id="<?= $column_name ?>" name="<?= $column_name ?>">
                    <?php elseif (stripos($col['Type'], 'int') !== false): ?>
                        <input type="number" class="form-control" id="<?= $column_name ?>" name="<?= $column_name ?>">
                    <?php else: ?>
                        <input type="text" class="form-control" id="<?= $column_name ?>" name="<?= $column_name ?>">
                    <?php endif; ?>
                    
                    <?php if ($col['Null'] === 'NO'): ?>
                        <small class="text-danger">* 必填</small>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            
            <button type="submit" class="btn btn-primary">儲存</button>
            <a href="list-content-admin.php?table=<?= htmlspecialchars($table) ?>" class="btn btn-secondary">取消</a>
        </form>
    </div>


    <?php include __DIR__ . '/parts/html-scripts.php' ?>
</body>

<?php include __DIR__ . '/parts/html-tail.php' ?>

