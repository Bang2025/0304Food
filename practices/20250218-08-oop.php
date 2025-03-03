<?php
# Object-oriented programming

header('Content-Type: text/plain');


class Person
{
  # 屬性宣告
  public $name;
  public $mobile;
  private $sno = 'secret'; # 私有屬性
}

$p1 = new Person(); # 依照 Person 類型的設定建立一個個體 (instance, 實體)
$p1->name = '小明'; # 屬性設定

echo "$p1->name \n\n";
# echo "$p1->sno \n\n"; # 發生錯誤, 不能存取私有屬性