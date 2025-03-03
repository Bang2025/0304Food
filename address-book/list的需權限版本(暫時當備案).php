大致上就是放在$table_permissions 這個陣列的附近

// 首先，確保 session 已啟動
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 表格的權限配置
$table_permissions = [
    // 所有管理員都可以操作的表格
    'admin' => [
        'categories',
        'chatmessages',
        'contactus',
        'food_products',
        'ingredients',
        'product_reviews',
        'qanda',
        'recipes',
        'recipe_categories',
        'recipe_images',
        'recipe_tags',
        'steps',
        'tags'
    ],
    // 只有超級管理員才能操作的表格
    'super_admin' => [
        'users',
        'members',
        'orders',
        'order_items',
        'carts'
    ]
];

// 獲取當前用戶角色 (假設存儲在 session 中)
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'admin';

// 確定當前用戶可以操作的表格
$allowed_tables = $table_permissions['admin'];
if ($user_role === 'super_admin') {
    $allowed_tables = array_merge($table_permissions['admin'], $table_permissions['super_admin']);
}



下面的$table_titles 陣列要記得改成這樣
// 擴展表格標題
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