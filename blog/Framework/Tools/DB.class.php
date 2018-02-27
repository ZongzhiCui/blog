<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/19
 * Time: 14:57
 */
header('Content-Type:text/html; charset=utf-8');
/**
 * DB类用于执行SQL语句
 * Class DB
 */
class DB
{
    private $pdo;
    private $psn;
    private $username;
    private $password;
    private $errmode;
    //私有的静态变量保存创建好的对象
    private static $instance = null;
    private function __construct($config=[])
    {
        if(empty($config)){
            $config_file = include_once CONFIG_PATH.'application.config.php';
            $config = $config_file['pdo'];
        }
        /**把传的参数赋值给成员属性**/
        $this->psn = $config['psn']??'mysql:host=127.0.0.1;dbname=blog;charset=utf8;port=3306';
        $this->username = $config['username']??'root';
        $this->password = $config['password'];
        $this->errmode = $config['errmode']??[PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT];

        //NEW pdo对象输入数据源,帐号,密码和错误模式
        $this->pdo = new PDO($this->psn, $this->username, $this->password,$this->errmode);
    }

    /**静态方法获取一个对象并返回给静态成员变量**/
    //如果创建了对象可不可以让他直接使用之前的对象!不赋值静态变量.
    public static function getInstance($config=[]){
//        if(self::$instance == null){
        //**判断这个成员属性是否为自身类的一个实例
        if(!self::$instance instanceof self){ // 语法: $pdo instanceof 类名 --- 检测$pdo是否是类名的实例
//            self::$instance = new DB($config);
            self::$instance = new self($config);
        }
        return self::$instance;
    }
    //设置克隆为私有,最终一步完成单例
    private function __clone()
    {
    }
    /**执行SQL的方法private**/
    private function query($sql){
        $stm = $this->pdo->query($sql);
        if($stm === false){
            die(
                '执行SQL失败!<br>'.
                '错误编码:'.$this->pdo->errorCode().'<br>'.
                '错误信息:'.$this->pdo->errorInfo()[2].'<br>'.
                '错误的SQL:'.$sql.'<br>'
            );
        }
        /**执行SQL需要返回结果集**/
        return $stm;
    }
    /**实现fetchAll($sql),执行sql,解析完毕,返回二维数组**/
    public function fetchAll($sql){
        $stm = $this->query($sql);
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
        if ($rows === false){
            die($this->pdo->errorInfo()[2]);
        }
        return $rows;
    }
    /**实现fetchRow($sql),执行sql,解析完毕,返回一维数组**/
    public function fetchRow($sql){
        $stm = $this->query($sql);
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if ($row === false){
            die($this->pdo->errorInfo()[2]);
        }
        return $row;
    }
    /**
     * @param $sql SQL语句
     * @param int $col 第几列的字段(默认第一行第0列)
     * @return mixed 返回第一行第0列的值(默认)
     */
    public function fetchColumn($sql,$column_number=0){
        $stm = $this->query($sql);
        $col = $stm->fetchColumn($column_number);
        if ($col === false){
            die($this->pdo->errorInfo()[2]);
        }
        return $col;
    }
    /**执行SQL用execute**/
    public function execute($sql){
        //返回执行SQL所影响的条数
        $num = $this->pdo->exec($sql);
        if ($num === false){
            die($this->pdo->errorInfo()[2]);
        }
        return $num;
    }
    /**
     * 设置序列化和反序列化对象的方法
     */
    public function __sleep()
    {
        return ['host','username','password','dbname','port','charset'];
    }
    /**反序列化 重新连接 数据库,并设置字符集**/
    public function __wakeup()
    {
//        $this->connect();
//        $this->setCharset();
    }
    /**功能实现完毕 执行 析构方法**/
    public function __destruct()
    {
        //脚本执行完毕执行这里
    }
    public function __invoke()
    {
        echo '报错:对象被作为方法调用,如: 对象名称()';
    }
    public function __toString()
    {
        return '报错:对象被当作字符串输出了';
    }
    //设置一个私有的扩展属性,用于保存新增的属性名
    private $extra = [];
    public function __set($name, $value)
    {
        echo '你设置了一个不存在或不可访问的成员属性<br>';
        if(in_array($name,['name','age'])){ //假设这个成员属性存在在已有的成员属性中
            $this->$name = $value;
        }else{
            $this->extra[$name] = $value;
        }
    }
    public function __get($name)
    {
        echo '你正在获取不可访问或者不存在的成员属性的值<br>';
        if(in_array($name,['name','age'])){
            return $this->$name;
        }elseif(isset($this->extra[$name])){
            return $this->extra[$name];
        }
    }
    public function __unset($name)
    {
        echo '报错:你删除了一个不可访问或者不存在的成员属性!<br>';
    }
    public function __isset($name)
    {
        echo '检测了一个不不可访问或者不存在的变量';
        return isset($this->$name);
    }
    public function __call($name, $arguments)
    {
        echo '用对象调用了一个不存在或不可访问的方法!--一般应用在跳转到首页!';
    }
    public static function __callStatic($name, $arguments)
    {
        echo '用静态方法调用了一个不存在或不可访问的方法!--一般应用在跳转到首页!';
    }
}
/*该类DB的使用如下:
$sql="select * from user";
$select = new DB('127.0.0.1','root','root',3306,'utf8','day_one'); 最后一个可以省略
//$this->username = 'root1';
$select->query($sql);*/
/**
 * 序列化相关
 */
//创建对象
/*$instance = DB::getInstance(['password'=>'root','database'=>'day_one']);
//序列化对象,用于保存数据(从内存到U盘)
$str = serialize($instance);
file_put_contents('./data.txt',$str,FILE_APPEND);
//反序列化对象,用于取出数据(从硬盘到内存)
$str = file_get_contents('./data.txt');
$instance = unserialize($str);*/