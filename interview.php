<?php

/**
 * 单例模式
 * 保证一个类只存在一个实例，提供一个全局访问点（三私一公 私有的静态变量 私有的克隆对象 私有的构造函数 公共的静态方法） 防止多次实例化（new）
 * instanceof  判断一个对象是否是某个类的实例（判断是否实例化 存在则直接返回）
 * 单例模式与静态变量的区别：单例模式强制类只能实力化一次，静态变量为了减少new的操作，但是不能阻止new和clone
 */
class A
{
    public function show()
    {
        echo "我是A类函数，要调用B类函数和C类函数<br/>";
        $b = Unit::getInstance('B');
        $b->show();
        $c = Unit::getInstance('C');
        $c->show('A');
    }
}

class B
{
    public function show()
    {
        echo "我是B类函数，要调用C类函数<br/>";
        $c = Unit::getInstance('C');
        $c->show('B');
    }
}

class C
{
    public function __construct()
    {
        echo "C类被创建<br>";
    }

    public function show($parm)
    {
        echo "我是C类函数，现在被{$parm}类函数调用<br/>";
    }
}

class Unit
{
    static public function getInstance($class)
    {
        static $arr = null;
        if (!isset($arr[$class]) || !$arr[$class] instanceof $class) {
            $arr[$class] = new $class();
        }

        return $arr[$class];
    }
}

$a = new A();
$a->show();

/**
 * 工厂模式
 * // 由工厂类根据参数来决定创建出哪一种产品类的实例；
 * // 工厂类是指包含了一个专门用来创建其他对象的方法的类。所谓按需分配，传入参数进行选择，返回具体的类。
 * // 工厂模式的最主要作用就是对象创建的封装、简化创建对象操作。
 * // 简单的说，就是调用工厂类的一个方法（传入参数）来得到需要的类；
 * 工厂模式是创建型的设计模式，它接受指令，创建出符合要求的实例；它主要解决的是资源的统一分发，将对象的创建完全独立出来，让对象的创建和具体的使用客户无关。主要应用在多数据库选择，类库文件加载等。
 */
// 抽象运算类
abstract class Operation
{
    abstract public function getVal($i, $j); // 抽象方法不能包含方法体
}

// 加法类
class OperationAdd extends Operation
{
    public function getVal($i, $j)
    {
        return $i + $j;
    }
}

// 减法类
class OperationSub extends Operation
{
    public function getVal($i, $j)
    {
        return $i - $j;
    }
}

//乘法类
class OperationMul extends Operation
{
    public function getVal($i, $j)
    {
        return $i * $j;
    }
}

//计数器工厂
class CounterFactor
{
    // 工厂生产特定类对象方法
    public static function createOperation($operation)
    {
        return new $operation;
    }
}

$counter = CounterFactor::createOperation('OperationSub');
echo $counter->getVal(10, 2);
echo "<br>";


/**
 * 冒泡排序
 * 两两对比，在排序的过程中，小数往前，大数往后
 */

$data  = [2, 1, 45, 12, 5, 21, 88, 111];
$count = count($data);
for ($i = 0; $i < $count; $i++) {
    for ($j = $i + 1; $j < $count; $j++) {
        if ($data[$i] > $data[$j]) {
            $temp     = $data[$i];
            $data[$i] = $data[$j];
            $data[$j] = $temp;
        }
    }
}
print_r($data);
echo "<br>";
/**
 * 选择排序
 * 每一次从待排序的数据元素中选出最小（或最大）的一个元素，存放在序列的起始位置，直到全部待排序的数据元素排完。
 *  选择排序是不稳定的排序方法（比如序列[5， 5， 3]第一次就将第一个[5]与[3]交换，导致第一个5挪动到第二个5后面）
 */
$res = [545, 54, 12, 154, 998, 232];
$c   = count($res);
for ($i = 0; $i < $c - 1; $i++) {
    $minIndex = $i;
    for ($k = $i + 1; $k < $c; $k++) {
        if ($res[$minIndex] > $res[$k]) {
            $minIndex = $k;
        }
    }
    if ($minIndex != $i) {
        $temp           = $res[$minIndex];
        $res[$minIndex] = $res[$i];
        $res[$i]        = $temp;
    }
}
print_r($res);

/**
 * 快速排序
 */
$arr  = [232,31,321,435,33421];
$result  = quickSort($arr);
print_r($result);
function quickSort($arr){
    $count  = count($arr);
    if ($count <= 1) {
        return $arr;
    }
    $res  = $arr[0];
    $one  = [];
    $two  = [];
    for ($i=1; $i <$count ; $i++) { 
        if ($arr[$i] > $res) {
            $one[]   = $arr[$i];
        }else{
            $two[]   = $arr[$i];
        }
    }
    $one   = quickSort($one);
    $two   = quickSort($two);
    return array_merge($two,[$res],$one);
}

/**
 * 接口类
 * interface定义 不能继承 只能通过implements操作符调用  指定某个类必须实现全部方法，不需要定义具体内容 否则会报致命错误
 * 方法只能使用public 定义  
 */
interface Aa
{
    public function aa($a);

    public function bb($b);

    public function cc($c);

}

interface Bb
{
    public function vv();
}

class Aaa implements Aa,Bb
{
    public function aa($a)
    {
        return $a;
    }

    public function bb($b)
    {
        return $b;
    }
    public function cc($c)
    {
        return $c;
    }
    public function vv()
    {
        echo 'vv';
    }
}

$a  = new Aaa();
echo $a->aa('aa');
echo "<br>";
echo $a->vv();

/**
 * 抽象类与抽象方法
 * 抽象类：可以被继承extends，abstract来修饰，不能直接new对象  只要类里面存在一个抽象方法都属于抽象类，必须要用abstract来修饰 在抽象类中可以有不是抽象方法与成员属性
 * 抽象方法：必须要用abstract来修饰并且没有结构体（在方法声明的时候没有大括号以及内容）
 * 子类必须实现父类中全部的抽象方法，没有全部实现的话，子类还是一个抽象类，还不能被实例化
 */
class B extends Aa
{
    //子类必须实现父类的抽象方法，否则是致命的错误。
    public function say()
    {
        echo '这是say方法,实现了抽象方法';
    }

    public function eat($argument)
    {
        echo '抽象类可以有参数 ，输出参数：'.$argument;
    }
}
$b =new B;
$b->say();
echo '<br>';
$b->eat('apple');
echo '<br>';
$b->run();
abstract class Aa
{
    abstract public function say();

    abstract public function eat($a);

    public function run()
    {
        echo "run";
    }
}

/**
 * php 重写
 * 当父类与子类有一个方法 参数 名称都一样 子类会覆盖父类的方法
 * 在实行方法覆盖的时候，访问修饰符可以是不一样的，但是子类的访问权限必须大于父类的访问权限
 */
class B extends A{
    public function aaa()
    {
        echo 'Baaa';
    }
}

$b  = new B;
echo $b->aaa();

class A {
    public function aaa(){
        echo 'Aaaa';
    }
}

/**
 * php 重载 魔术方法
 * 重载在“通常面向对象语言”中的含义：是指，在一个类（对象）中，有多个名字相同但形参不同的方法的现象；
 * 在php中 当对一个对象或者类使用不存在的属性或者方法时，对于出错信息进行处理
 */
class A
{
    public $p1 = 1;

    //当对一个对象不存在的属性进行取值的时候 自动调用__GET
    function __get($name)
    {
        echo "$name 暂时没有定义";
    }
    //当对一个对象不存在的属性进行赋值的时候 自动调用__SET
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        echo "$name 不存在不能赋值 $value";
    }
    //当对一个对象不存在的属性进行判断的时候 自动调用__isset
    public function __isset($name)
    {
        // TODO: Implement __isset() method.
        echo "该 $name 没有定义不能进行判断";
    }
    //销毁
    public function __unset($name)
    {
        // TODO: Implement __unset() method.
        echo "该 $name 属性没有定义 不能删除";
    }
    //一个对象不存在的方法进行调用的时候 自动调用__call
    public function __call($name, $arguments)
    {
        echo "$name 该方法没有定义";
    }
    //将对象转为字符串调用时 比如 echo 直接输出
    public function __toString()
    {
        // TODO: Implement __toString() method.
        echo "不能已字符串输出";
    }

    //把对象当成一个函数去执行 调用__invoke
    public function __invoke()
    {
        // TODO: Implement __invoke() method.
        echo "invoke";
    }
    //
    public function __clone()
    {
        // TODO: Implement __clone() method.
        echo "it is not clone";
    }

    //
    public function text()
    {
        echo 'text';
    }

    public function text1()
    {
        echo 'text1';
    }
}
$a = new A;
echo $a->aaa();//__call
echo "<br>";
echo $a->p1;
echo "<br>";
echo $a->p2;//__get
echo "<br>";
echo $a->p2  = 2;//__set
echo "<br>";
echo isset($a->p2);//__isset
echo "<br>";
unset($a->p2);//__isset
echo "<br>";
echo $a();//__invoke
echo "<br>";
echo $a;//__tostring
echo "<br>";
clone $a;//__clone

/**
 * php多继承 trait 
 * 通过在类中使用use 修饰用trait 
 * 多个类中有相同的方法可以通过 insteadof 代替 或者 as 重命名 
 * 可以修改访问控制  还可以使用抽象方法、静态属性、静态方法
 */
class B extends A{
    use Dog;
    public function aa()
    {
        echo "this is b";
    }
}

$b  = new B();
$b->aa();
echo "<br>";
echo $b->bark();
echo "<br>";
echo $b->eat();
echo "<br>";
trait Dog{
    public $name = 'dog';
    public function bark(){
        echo 'this is  dog';
    }
}

class A{
    public function eat(){
        echo "this is a";
    }
}

/**
 * 递归
 */
$array = array(
array('id' => 1, 'pid' => 0, 'name' => '河北省'),
array('id' => 2, 'pid' => 0, 'name' => '北京市'),
array('id' => 3, 'pid' => 1, 'name' => '邯郸市'),
array('id' => 4, 'pid' => 2, 'name' => '朝阳区'),
array('id' => 5, 'pid' => 2, 'name' => '通州区'),
array('id' => 6, 'pid' => 4, 'name' => '望京'),
array('id' => 7, 'pid' => 4, 'name' => '酒仙桥'),
array('id' => 8, 'pid' => 3, 'name' => '永年区'),
array('id' => 9, 'pid' => 1, 'name' => '武安市'),
);

$res   = getTree($array);

foreach ($res as $key => $value) {
    echo str_repeat('--', $value['level']),$value['name']."<br>";
}
function getTree($arr,$pid=0,$level=0){
    static $list   = [];
    foreach ($arr as $key => $value) {
        if ($value['pid'] == $pid) {
            $value['level']  = $level;
            $list[]  = $value;
            unset($arr[$key]);
            getTree($arr,$value['id'],$level+1);
        }
    }
    return $list;
}

$arr = [
    ['0'=>[
        'da'=>32
    ]]
];
$da  = res($arr);
print_r($da);
function res($arr){
    $re   = 1;
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            $deep   = res($value)+1;
            if ($deep > $re) {
                $re  = $deep;
            }
        }
    }
    return $re;
}
print_r($arr);die;