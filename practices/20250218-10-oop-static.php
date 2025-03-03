<?php
header("Content-Type: application/json");
class Person{
    
    //靜態
    public static $count = 0;
    const MY_CONST = 1;
    public $name;
    public $mobile;
    private $sno = "1234";  //私有屬性 ，只能在這個類別class裡面使用

    
    
    //建構函式，物件在建立完成時去呼叫
    function __construct($name,$mobile="0918222888"){
        Person::$count++;
        $this->name = $name;
        $this->mobile = $mobile;
    }
}

//用Person這個類別來建立物件、建立個體(instance)
$p1 = new Person("小王","0918222333");
$p1->name = "小明";  //屬性設定


echo 'Person::$count'.Person::$count;
echo "\n\n";
echo $p1->name;
$p1 = new Person("小王","0918222333");
$p2 = new Person("小名");
echo 'Person::$count'.Person::$count;
echo "\n\n";
echo 'Person::MY_CONST'.Person::MY_CONST;
echo "\n\n";


?>