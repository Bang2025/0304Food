<?php

header('Content-Type: text/plain');

$str = '{"name":"小明", "gender":"男"}';

$obj = json_decode($str);

# var_dump($obj);
echo "$obj->name \n\n";

$ar = json_decode($str, true);

echo "{$ar['name']} \n\n";

var_dump(json_decode('[}', true)); # NULL