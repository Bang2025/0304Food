<?php
// 初始設置部分
// $db_host = 'localhost';
// $db_user = 'username';
// $db_pass = 'password';
// $db_name = 'database_name';
// $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

require __DIR__ . "/parts/db-connect.php"; 


// 獲取要查詢的資料表 (默認為 recipes) 。 使用isset的用意為防止SQL惡意攻擊 (因為會先判斷是否存在這個變數)
$table = isset($_GET['table']) ? $_GET['table'] : 'recipes';

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
// 添加您允許查詢的表格
// 檢查請求的表格是否在白名單中
// if (!in_array($table, $allowed_tables) || $id <= 0) {
//   header('Location: list-content-admin.php');
//   exit;
// }




if (!in_array($table, $allowed_tables)) {
    $table = 'recipes'; // 如果不是允許的表，默認使用 recipes
}

// 獲取表格結構，用於動態生成列
$stmt = $pdo->prepare("DESCRIBE {$table}");
$stmt->execute();
$columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

// 搜索和排序參數
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort_field = isset($_GET['sort_by']) ? $_GET['sort_by'] : $columns[0];
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// 構建查詢
$sql = "SELECT * FROM {$table} WHERE 1=1";

// 添加搜索條件 (搜尋所有欄位)
if (!empty($search)) {
    $sql .= " AND (";
    $search_conditions = [];
    foreach ($columns as $column) {
        $search_conditions[] = "{$column} LIKE :search";
    }
    $sql .= implode(" OR ", $search_conditions) . ")";
}

// 添加排序
if (in_array($sort_field, $columns)) {
    $sql .= " ORDER BY {$sort_field} {$sort_order}";
}

// 分頁
$items_per_page = 30;  //這邊的數字表示一頁呈現幾筆  。目前一頁太少筆的話會壞掉(有空再來debug)
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

// 計算總頁數
$count_sql = "SELECT COUNT(*) FROM {$table} WHERE 1=1";
if (!empty($search)) {
    $count_sql .= " AND (";
    $count_sql .= implode(" OR ", $search_conditions) . ")";
}
$stmt = $pdo->prepare($count_sql);
if (!empty($search)) {
    $stmt->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
}
$stmt->execute();
$total_items = $stmt->fetchColumn();
$totalPages = ceil($total_items / $items_per_page);

// 計算偏移量
$offset = ($page - 1) * $items_per_page;
$sql .= " LIMIT {$offset}, {$items_per_page}";

// 執行查詢
$stmt = $pdo->prepare($sql);
if (!empty($search)) {
    $stmt->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
}
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 獲取主鍵（通常是第一個欄位）
$primary_key = $columns[0];

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
$page_title = isset($table_titles[$table]) ? $table_titles[$table] : '資料管理';
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="my-4"><?= $page_title ?></h1>
        
        <!-- 表格切換按鈕 -->
         <!-- 細節，這邊就是會從上面的$allowed_tables陣列來抓出成員，並放進$t  。 緊接著生成網址?table+$t這樣 -->
        <div class="mb-3">
            <?php foreach ($allowed_tables as $t): ?>
                <a href="?table=<?= $t ?>" class="btn <?= $t === $table ? 'btn-primary' : 'btn-outline-primary' ?> me-2">
                    <?= isset($table_titles[$t]) ? $table_titles[$t] : ucfirst($t) ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <!-- 搜索表單 -->
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="搜尋..." value="<?= htmlspecialchars($search) ?>">
                <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
                <button class="btn btn-primary" type="submit">搜尋</button>
            </div>
        </form>

        <!-- 分頁 -->
        <div class="row">
            <div class="col mt-4 mb-2">
                <nav aria-label="Page navigation">
                    <ul class="pagination d-flex align-items-center">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>">
                                <i class="fa-solid fa-angles-left"></i>
                            </a>
                        </li>
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => max(1, $page - 1)])) ?>">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                        </li>

                        <?php for ($i = max(1, $page - 5); $i <= min($totalPages, $page + 5); $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => min($totalPages, $page + 1)])) ?>">
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </li>
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $totalPages])) ?>">
                                <i class="fa-solid fa-angles-right"></i>
                            </a>
                        </li>
                        <!-- 新增按鈕 -->
                        <button type="button" class="btn btn-primary ms-auto" onclick="location.href='add.php?table=<?= htmlspecialchars($table) ?>'">新增</button>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- 資料表格 -->
        <div class="row">
            <div class="col">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-trash"></i></th>
                            <?php foreach ($columns as $column): ?>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, [
                                        'sort_by' => $column,
                                        'order' => ($sort_field == $column && $sort_order == 'ASC') ? 'DESC' : 'ASC'
                                    ])) ?>">
                                        <?= htmlspecialchars($column) ?>
                                        <?php if ($sort_field == $column): ?>
                                            <i class="fa-solid fa-sort-<?= $sort_order == 'ASC' ? 'up' : 'down' ?>"></i>
                                        <?php endif; ?>
                                    </a>
                                </th>
                            <?php endforeach; ?>
                            <th><i class="fa-solid fa-pen-to-square"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td>
                                    <a href="javascript: deleteOne('<?= $table ?>', <?= $row[$primary_key] ?>)">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                                <?php foreach ($columns as $column): ?>
                                    <td class="search-field"><?= htmlspecialchars($row[$column]) ?></td>
                                <?php endforeach; ?>
                                <td>
                                    <a href="edit.php?table=<?= htmlspecialchars($table) ?>&id=<?= $row[$primary_key] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function deleteOne(table, id) {
            if (confirm('確定要刪除這筆資料嗎？')) {
                location.href = `delete.php?table=${table}&id=${id}`;
            }
        }
    </script>
</body>
</html>
