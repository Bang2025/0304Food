<?php

$pw = '123456';  //密碼
$hash ="$2y$10$2CYoYZPD4ugpJfSRyM3Zb.TnhcjA2tmmXfqKCKejO.5YtkebyswRm";  //該密碼的hash編譯結果


//這邊可以核對出該密碼與hash編譯結果是否相同 。結果會顯示true或false
var_dump(password_verify($pw, $hash));   

?>