// 表格特殊處理配置（可以放在文件頂部，與 add.php 共用相同的配置）
$table_config = [
    'recipes' => [
        'foreignKeys' => [
            'category_id' => [
                'table' => 'categories',
                'key' => 'id',
                'display' => 'name'
            ],
            'user_id' => [
                'table' => 'users',
                'key' => 'id',
                'display' => 'username'
            ]
        ],
        'validation' => [
            'title' => ['required', 'min_length' => 3],
            'content' => ['required']
        ]
    ],
    'users' => [
        'validation' => [
            'email' => ['required', 'email', 'unique_except_self'],
            'password' => ['optional', 'min_length' => 8]
        ],
        'password_hash' => true // 標記需要哈希密碼
    ]
];

// 特殊處理邏輯（放在 if ($_SERVER['REQUEST_METHOD'] === 'POST') 內）
if (isset($table_config[$table])) {
    $config = $table_config[$table];
    
    // 密碼哈希處理 - 編輯時只在有輸入新密碼時才處理
    if (isset($config['password_hash']) && $config['password_hash'] && !empty($_POST['password'])) {
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } elseif (isset($config['password_hash']) && $config['password_hash'] && empty($_POST['password'])) {
        // 如果密碼欄位為空，則不更新密碼（保留原密碼）
        unset($_POST['password']);
    }
    
    // 驗證處理
    if (isset($config['validation'])) {
        $errors = [];
        foreach ($config['validation'] as $field => $rules) {
            // 只有在欄位存在於 POST 數據中時才進行驗證
            if (isset($_POST[$field])) {
                if (isset($rules['required']) && (empty($_POST[$field]) || $_POST[$field] === '')) {
                    $errors[$field][] = "{$field} 為必填欄位";
                }
                
                if (isset($rules['optional']) && empty($_POST[$field])) {
                    // 選填欄位為空時跳過其他驗證
                    continue;
                }
                
                if (isset($rules['min_length']) && strlen($_POST[$field]) < $rules['min_length']) {
                    $errors[$field][] = "{$field} 長度必須至少為 {$rules['min_length']} 個字符";
                }
                
                if (isset($rules['email']) && !filter_var($_POST[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = "{$field} 必須是有效的電子郵件地址";
                }
                
                if (isset($rules['unique_except_self'])) {
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM {$table} WHERE {$field} = :value AND {$primary_key} != :id");
                    $stmt->execute(['value' => $_POST[$field], 'id' => $id]);
                    if ($stmt->fetchColumn() > 0) {
                        $errors[$field][] = "{$field} 已存在，請使用其他值";
                    }
                }
            }
        }
        
        // 如果有錯誤，顯示它們
        if (!empty($errors)) {
            $error_messages = [];
            foreach ($errors as $field => $field_errors) {
                foreach ($field_errors as $error) {
                    $error_messages[] = $error;
                }
            }
            // 儲存錯誤信息到 session 以便在重定向後顯示
            $_SESSION['form_errors'] = $error_messages;
            $_SESSION['form_data'] = $_POST; // 保留表單數據
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        }
    }
}