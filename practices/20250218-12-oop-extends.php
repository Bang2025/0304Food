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

class Employee extends Person
{
  public $employee_id;
  function __construct($name, $mobile, $employee_id)
  {
    parent::__construct($name, $mobile); # 呼叫父類別的建構子
    $this->employee_id = $employee_id;
  }
}

$e1 = new Employee("David", "0925", "B007");
# $e1->employee_id = 'A006';
echo json_encode($e1, JSON_PRETTY_PRINT);
