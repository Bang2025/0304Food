<?php
header("Content-Type: application/json");
class Person{
    //這邊只是宣告
    public $name;
    public $mobile;
    private $sno = "1234";  //私有屬性 ，只能在這個類別class裡面使用

    
    
    //建構函式，物件在建立完成時去呼叫
    function __construct($name,$mobile="0918222888"){
        $this->name = $name;
        $this->mobile = $mobile;
    }
    public function toJSON(){
        return json_encode($this,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    } 
    //getter 讀取器
    function getSno(){
        return $this->sno;
    }
    //setter 讀取器。呼叫之後可以更改私有屬性的值。請見$p1->setSno("新的資料"); 這一行
    function setSno( $sno ){
        $this->sno = $sno;
    }

}

//用Person這個類別來建立物件、建立個體(instance)
$p1 = new Person("小王","0918222333");
$p1->name = "小明";  //屬性設定

echo $p1->name;
// echo $p1->sno;   //私有屬性不能在全域使用

var_dump($p1);
$p2 = new Person("大華");
var_dump($p2);
echo "\n\n";
echo $p1->getSno();
echo "\n\n";
$p1->setSno("新的資料");
echo $p1->getSno();


?>