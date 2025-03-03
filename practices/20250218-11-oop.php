<?php
# Object-oriented programming

header('Content-Type: text/plain');


class Person
{
  # 靜態的特徵
  static public $count = 0;
  const MY_CONST = '123';

  # 屬性宣告
  public $name;
  public $mobile;
  private $sno = 'secret';
  # 建構函式, 建構子, 物件在建立完成時呼叫
  function __construct($name, $mobile = '0935')
  {
    Person::$count++;
    $this->name = $name;
    $this->mobile = $mobile;
  }
}
echo 'Person::$count ' . Person::$count;
echo "\n\n";
$p1 = new Person('小華', '0918');
$p2 = new Person('小明');
echo 'Person::$count ' . Person::$count;
echo "\n\n";
echo 'Person::MY_CONST ' . Person::MY_CONST;
echo "\n\n";
