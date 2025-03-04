<?php

ob_start();
require __DIR__ . "/parts/admin-required.php"; # 需要管理者權限
require __DIR__ . "/parts/db-connect.php";
$title = '編輯通訊錄';


// 獲取要操作的資料表和 ID
$table = isset($_GET['table']) ? $_GET['table'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

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
$stmt = $pdo->prepare("DESCRIBE {$table}");
$stmt->execute();
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 獲取主鍵名稱
$stmt = $pdo->prepare("SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'");
$stmt->execute();
$primary_key = $stmt->fetch(PDO::FETCH_ASSOC)['Column_name'];

// 如果是表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 創建一個欄位名稱的索引數組，方便後續檢查
    $column_names = array_column($columns, 'Field');

    // 構建 SQL 更新語句
    $update_fields = [];
    $params = [];

    foreach ($columns as $col) {
        $column_name = $col['Field'];

              // 如果是 updated_at 欄位，設定為當前時間
              if ($column_name == 'updated_at') {
               $update_fields[] = "{$column_name} = NOW()";
               continue;
              }


              // 跳過主鍵和 created_at
           if ($column_name != $primary_key && $column_name != 'created_at' && isset($_POST[$column_name])) {
             $update_fields[] = "{$column_name} = :{$column_name}";
             $params[":{$column_name}"] = $_POST[$column_name] ?: null;
         }
        } 

            // 確保 updated_at 被包含（如果表格有此欄位但尚未被處理）
         if (!in_array('updated_at = NOW()', $update_fields) && in_array('updated_at', $column_names)) {
           $update_fields[] = "updated_at = NOW()";
       }



    // 只有在有欄位需要更新時才執行 SQL
    if (!empty($update_fields)) {

    $sql = "UPDATE {$table} SET " . implode(', ', $update_fields) . " WHERE {$primary_key} = :id";
    $params[':id'] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    }

    header("Location: list-content-admin.php?table={$table}");
    exit;
}

// 查詢現有數據
$stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$primary_key} = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header('Location: list-content-admin.php');
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
$page_title = isset($table_titles[$table]) ? $table_titles[$table] : '編輯資料';
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
                <?php if ($column_name != $primary_key && $column_name != 'created_at' && $column_name != 'updated_at'): ?>
                  <div class="mb-3">
                        <label for="<?= $column_name ?>" class="form-label"><?= htmlspecialchars($column_name) ?></label>
                        
                        <?php if (stripos($col['Type'], 'text') !== false): ?>
                            <textarea class="form-control" id="<?= $column_name ?>" name="<?= $column_name ?>" rows="4"><?= htmlspecialchars($row[$column_name]) ?></textarea>
                        <?php else: ?>
                            <input type="text" class="form-control" id="<?= $column_name ?>" name="<?= $column_name ?>" value="<?= htmlspecialchars($row[$column_name]) ?>">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <button type="submit" class="btn btn-primary">儲存</button>
            <a href="list-content-admin.php?table=<?= htmlspecialchars($table) ?>" class="btn btn-secondary">取消</a>
        </form>
    </div>
</body>
</html>