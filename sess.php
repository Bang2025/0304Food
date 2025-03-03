<?php
# 查看 SESSION 的工具

header('Content-Type: application/json');

session_start(); # 啟用 session 的功能

echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);
