<?php

header('Content-Type: application/json');

echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
