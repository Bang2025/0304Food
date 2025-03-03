<?php
# Object-oriented programming

header('Content-Type: text/plain');


class Person
{
  # 屬性宣告
  public $name;
  public $mobile;
  # 建構函式, 建構子, 物件在建立完成時呼叫
  function __construct($name, $mobile = '0935')
  {
    $this->name = $name;
    $this->mobile = $mobile;
  }
}

$p1 = new Person('小華', '0918');

echo "$p1->name \n\n";

var_dump($p1);
$p2 = new Person('小明');
var_dump($p2);
