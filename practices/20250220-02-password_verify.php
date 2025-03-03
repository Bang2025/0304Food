<?php 

$pw = '123456';
$hash = '$2y$10$srnTo33LrG0AJgmNdCPC7.hIxRCBsY30Q17.kxUf6DewQrPXpFqNm';

var_dump(password_verify($pw, $hash));
