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