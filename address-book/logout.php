<?php
require __DIR__ . "/parts/db-connect.php";

# session_destroy(); # 清除所有的 session

unset($_SESSION['admin']); # 相當於登出 admin 角色

header('Location: list.php');