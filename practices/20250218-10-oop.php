<?php
# Object-oriented programming

header('Content-Type: text/plain');


class Person
{
  # 屬性宣告
  public $name;
  public $mobile;
  private $sno = 'secret';
  # 建構函式, 建構子, 物件在建立完成時呼叫
  function __construct($name, $mobile = '0935')
  {
    $this->name = $name;
    $this->mobile = $mobile;
  }
  public function toJSON()
  {
    return json_encode($this, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  }
  # getter 讀取器
  function getSno()
  {
    return $this->sno;
  }
  # setter 設定器
  function setSno($val)
  {
    $this->sno = $val;
  }
}

$p1 = new Person('小華', '0918');

echo $p1->toJSON();
echo "\n\n" . $p1->getSno() . "\n\n";
$p1->setsno('新的資料');
echo "\n\n" . $p1->getSno() . "\n\n";
