<?php
header("Content-Type: application/json");
class Person{
    
    //靜態
 
    public $name;
    public $mobile;
    
    
    
    //建構函式，物件在建立完成時去呼叫
    function __construct($name,$mobile="0918222888"){
     
        $this->name = $name;
        $this->mobile = $mobile;
    }
}

//Employee繼承Person
class Employee extends Person{
    public $employee_id;
    function __construct($name,$mobile,$employee_id){
        //parent功能：繼承父類別的建構函式
        parent::__construct($name,$mobile);
      
        $this->employee_id = $employee_id;
       
    }

}
$e1 = new Employee("David","0918222888","A001");
// $e1->employee_id = "A001";
echo json_encode($e1,JSON_PRETTY_PRINT);

?>