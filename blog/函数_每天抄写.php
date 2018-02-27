<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/2/10
 * Time: 13:11
 */
header('Content-Type: text/html;charset=utf-8');
/**day_one**/
//>>1.number abs ( mixed $number )返回参数 number 的绝对值
$abs = abs(-4.2); // $abs = 4.2; (double/float)
$abs2 = abs(5);   // $abs2 = 5; (integer)
$abs3 = abs(-5);  // $abs3 = 5; (integer)

//>>2.float ceil ( float $value ) 进一取整
//>>3.float floor ( float $value )舍去法取整

//>>4.float fmod ( float $x , float $y )返回除法的浮点数余数
$x = 5.7;
$y = 1.3;
$r = fmod($x, $y);
// $r equals 0.5, because 4 * 1.3 + 0.5 = 5.7

//>>5.number pow ( number $base , number $exp ) 指数表达式 (返回数的 N 次方)
var_dump(pow(2, 8)); // int(256)
echo pow(-1, 20); // 1   n为奇数,（-1）^n=-1, n为偶数,（-1）^n=1,
echo pow(0, 0); // 1

echo pow(-1, 5.5); // PHP >4.0.6  NAN
echo pow(-1, 5.5); // PHP <=4.0.6 1.#IND

//>>6.float round ( float $val [, int $precision = 0 [, int $mode = PHP_ROUND_HALF_UP ]] ) 对浮点数进行四舍五入
echo round(3.6);         // 4
echo round(3.6, 0);      // 4
echo round(1.95583, 2);  // 1.96
echo round(1241757, -3); // 1242000

//>>7.float sqrt ( float $arg )平方根 (负数时返回 NAN。---??? )
echo sqrt(9); // 3
echo sqrt(10); // 3.16227766 ...

//>>8.mixed max ( array $values )
//mixed max ( mixed $value1 , mixed $value2 [, mixed $... ] )  找出最大值
//PHP 会将非数值的 string 当成 0，但如果这个正是最大的数值则仍然会返回一个字符串。如果多个参数都求值为 0 且是最大值，max() 会返回其中数值的 0，如果参数中没有数值的 0，则返回按字母表顺序最大的字符串。

//>>9.min() PHP 会将非数值的 string 当成 0，但如果这个正是最小的数值则仍然会返回一个字符串。如果多个参数都求值为 0 且是最小值，min() 会返回按字母表顺序最小的字符串，如果其中没有字符串的话，则返回数值的 0。

//>>10.mt_rand()更好的随机数    如果没有提供可选参数 min 和 max，mt_rand() 返回 0 到 mt_getrandmax() 之间的伪随机数
//>>11.rand
//>>12.float pi ( void )  得到圆周率值--默认值是 14
echo pi(); // 3.1415926535898

/**day_two**/
//>>13.string trim ( string $str [, string $character_mask = " \t\n\r\0\x0B" ] )去除字符串首尾处的空白字符（或者其他字符）
//可选参数，过滤字符也可由 character_mask 参数指定。一般要列出所有希望过滤的字符，也可以使用 ".." 列出一个字符范围。
//>>14.rtrim()===chop() 去除字符串右边的空白字符（或者其他字符） ===
//>>15.chop()等同于rtrim()
//>>16.ltrim — 删除字符串开头的空白字符（或其他字符）

//>>17.string dirname ( string $path ) 返回路径中的目录部分
//返回一个文件的目录名相当于去除最后的/加文件完整名称--strrchr($path.'/');

//>>18.string str_pad ( string $input , int $pad_length [, string $pad_string = " " [, int $pad_type = STR_PAD_RIGHT ]] )
//str_pad — 使用另一个字符串填充字符串为指定长度---用于制表 平均分配数据到表中
echo str_pad('22', 5, "0", STR_PAD_LEFT);   // 输出 "00022"
//>>19.string str_repeat ( string $input , int $multiplier )   重复一个字符串
echo str_repeat("&emsp;", 2);   //输出2个大空格 重复的字符串用于拼接其他字符串
//>>20.array str_split ( string $string [, int $split_length = 1 ] )  将字符串转换为数组
//split_length    每一段的长度。 默认为1
//>>21.string strrev ( string $string )  反转字符串 echo strrev("Hello world!"); // 输出 "!dlrow olleH"

//>>22.string wordwrap ( string $str [, int $width = 75 [, string $break = "\n" [, bool $cut = false ]]] )
//打断字符串为指定数量的字串    //str    输入字符串。     width   列宽度。
//break   使用可选的 break 参数打断字符串。
//cut   true不论是否单词直接切割.false如果是单词 单词后切割

//>>23.string str_shuffle ( string $str )  随机打乱一个字符串

/**day_three**/
//>>24.void parse_str ( string $str [, array &$arr ] )将字符串解析成多个变量
$str = "first=value&arr[]=foo+bar&arr[]=baz";
parse_str($str);
echo $first;  // value
echo $arr[0]; // foo bar
echo $arr[1]; // baz

parse_str($str, $output);
echo $output['first'];  // value
echo $output['arr'][0]; // foo bar
echo $output['arr'][1]; // baz

//>>25.string number_format ( float $number [, int $decimals = 0 ] )
//string number_format ( float $number , int $decimals = 0 , string $dec_point = "." , string $thousands_sep = "," )
//---以千位分隔符方式格式化一个数字
//number   //你要格式化的数字
//decimals   //要保留的小数位数
//dec_point   //指定小数点显示的字符
//thousands_sep   //指定千位分隔符显示的字符
//>>26.string strtolower ( string $string )将字符串转化为小写
//>>27.string strtoupper ( string $string )将字符串转化为大写
//---注意 "字母" 与当前所在区域有关。例如，在默认的 "C" 区域，字符 umlaut-a（?）就不会被转换。

//>>28.string ucfirst ( string $str )将字符串的首字母转换为大写
//>>29.string ucwords ( string $str [, string $delimiters = " \t\r\n\f\v"  ] )将字符串中每个单词的首字母转换为大写
//Example #2 ucwords() 自定义 delimiters 的例子
$foo = 'hello|world!';
$bar = ucwords($foo);             // Hello|world!
$baz = ucwords($foo, "|");        // Hello|World!

//>>30.string htmlentities ( string $string [, int $flags = ENT_COMPAT | ENT_HTML401 [, string $encoding = ini_get("default_charset") [, bool $double_encode = true ]]] )将字符转换为 HTML 转义字符
//ENT_COMPAT 会转换双引号，不转换单引号。   默认
//ENT_QUOTES 既转换双引号也转换单引号。
//>>31.string htmlspecialchars ( string $string [, int $flags = ENT_COMPAT | ENT_HTML401 [, string $encoding = ini_get("default_charset") [, bool $double_encode = true ]]] )将特殊字符转换为 HTML 实体
//某类字符在 HTML 中有特殊用处，如需保持原意，需要用 HTML 实体来表达。 本函数会返回字符转义后的表达。 如需转换子字符串中所有关联的名称实体，使用 htmlentities() 代替本函数。

//>>32.string nl2br ( string $string [, bool $is_xhtml = true ] )在字符串所有新行之前插入 HTML 换行标记
//>>33.string strip_tags ( string $str [, string $allowable_tags ] ) 从字符串中去除 HTML 和 PHP 标记
//allowable_tags   使用可选的第二个参数指定不被去除的字符列表。
//Example #1 strip_tags() 范例
$text = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
echo strip_tags($text);  //Test paragraph. Other text
// 允许 <p> 和 <a>
echo strip_tags($text, '<p><a>');//<p>Test paragraph.</p> <a href="#fragment">Other text</a>

/**day_four**/
//>>34.string addcslashes ( string $str , string $charlist )以 C 语言风格使用反斜线转义字符串中的字符
//当选择对字符 0，a，b，f，n，r，t 和 v 进行转义时需要小心，它们将被转换成 \0，\a，\b，\f，\n，\r，\t 和 \v。在 PHP 中，只有 \0（NULL），\r（回车符），\n（换行符）和 \t（制表符）是预定义的转义序列， 而在 C 语言中，上述的所有转换后的字符都是预定义的转义序列。
//>>35.string stripcslashes ( string $str )反引用一个使用 addcslashes() 转义的字符串 (需要反转义的字符串。)

//>>36.string addslashes ( string $str )使用反斜线引用字符串
//这些字符是单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）。
//>>37.string stripslashes ( string $str )反引用一个引用字符串

//>>38.string quotemeta ( string $str )转义元字符集
//返回 在下面这些特殊字符前加 反斜线(\) 转义后的字符串。 这些特殊字符包含：
//. \ + * ? [ ^ ] ( $ )
//>>39.string chr ( int $ascii )返回指定的字符
//返回相对应于 ascii 所指定的单个字符。
//此函数与 ord() 是互补的。
//>>40.ord — 返回字符的 ASCII 码值
//Example #1 ord() 范例
$str = "\n";
if (ord($str) == 10) {
    echo "The first character of \$str is a line feed.\n";
}

//>>41.int strcasecmp ( string $str1 , string $str2 )二进制安全比较字符串（不区分大小写）
//返回值::如果 str1 小于 str2 返回 < 0； 如果 str1 大于 str2 返回 > 0；如果两者相等，返回 0。
$var1 = "Hello";
$var2 = "hello";
if (strcasecmp($var1, $var2) == 0) {
    echo '$var1 is equal to $var2 in a case-insensitive string comparison';
}
//>>42.int strcmp ( string $str1 , string $str2 )二进制安全字符串比较(区分大小写)
//>>43.int strncmp ( string $str1 , string $str2 , int $len )二进制安全比较字符串开头的若干个字符
//该函数与 strcmp() 类似，不同之处在于你可以指定两个字符串比较时使用的长度（即最大比较长度）。
//注意该比较区分大小写。
//>>44.int strncasecmp ( string $str1 , string $str2 , int $len )二进制安全比较字符串开头的若干个字符（不区分大小写）
//该函数与 strcasecmp() 类似，不同之处在于你可以指定两个字符串比较时使用的长度（即最大比较长度）。

//>>45.int strnatcmp ( string $str1 , string $str2 )使用自然排序算法比较字符串
$arr1 = $arr2 = array("img12.png", "img10.png", "img2.png", "img1.png");
echo "Standard string comparison\n";
usort($arr1, "strcmp");
print_r($arr1);
echo "\nNatural order string comparison\n";
usort($arr2, "strnatcmp");
print_r($arr2);
/**
 * 以上例程会输出：
Standard string comparison
Array
(
[0] => img1.png
[1] => img10.png
[2] => img12.png
[3] => img2.png
)
Natural order string comparison
Array
(
[0] => img1.png
[1] => img2.png
[2] => img10.png
[3] => img12.png
)
 */
//>>46.int strnatcasecmp ( string $str1 , string $str2 )
//strnatcasecmp — 使用"自然顺序"算法比较字符串（不区分大小写）

//>>47.string chunk_split ( string $body [, int $chunklen = 76 [, string $end = "\r\n" ]] )将字符串分割成小块
//使用此函数将字符串分割成小块非常有用。例如将 base64_encode() 的输出转换成符合 RFC 2045 语义的字符串。它会在每 chunklen 个字符后边插入 end。

/**day_five**/
//>>48.string strtok ( string $str , string $token )
//string strtok ( string $token )标记分割字符串
$string = "This is\tan example\nstring";
/* 使用制表符和换行符作为分界符 */
$tok = strtok($string, " \n\t");

while ($tok !== false) {
    echo "Word=$tok<br />";
    $tok = strtok(" \n\t");
}
//>>49.array explode ( string $delimiter , string $string [, int $limit ] )使用一个字符串分割另一个字符串
//>>50.string implode ( string $glue , array $pieces )
//string implode ( array $pieces  )将一个一维数组的值转化为字符串

//>>51.string substr ( string $string , int $start [, int $length ] )返回字符串的子串
//>>52.mixed str_replace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] )子字符串替换
//>>53.str_ireplace — str_replace() 的忽略大小写版本
//>>54.int substr_count ( string $haystack , string $needle [, int $offset = 0 [, int $length ]] )计算字串出现的次数
//substr_count() 返回子字符串needle 在字符串 haystack 中出现的次数。注意 needle 区分大小写。

//>>55.mixed substr_replace ( mixed $string , mixed $replacement , mixed $start [, mixed $length ] )替换字符串的子串
///substr_replace() 在字符串 string 的副本中将由 start 和可选的 length 参数限定的子字符串使用 replacement 进行替换。

/**0217**/
//>>56.int similar_text ( string $first , string $second [, float &$percent ] )计算两个字符串的相似度
//返回在两个字符串中匹配字符的数目。

//>>57.string strrchr ( string $haystack , mixed $needle )查找指定字符在字符串中的最后一次出现
//>>58.string strstr ( string $haystack , mixed $needle [, bool $before_needle = false ] )查找字符串的首次出现...返回 haystack 字符串从 needle 第一次出现的位置开始到 haystack 结尾的字符串。
//>>59.strchr() 等同与strstr()
//>>60.stristr — strstr() 函数的忽略大小写版本

//>>61.string strtr ( string $str , string $from , string $to )
//string strtr ( string $str , array $replace_pairs )   转换指定字符
echo strtr("baab", "ab", "01"),"\n";  ///1001

//>>62.mixed strpos ( string $haystack , mixed $needle [, int $offset = 0 ] )查找字符串首次出现的位置
//返回 needle 在 haystack 中首次出现的数字位置。
// 忽视位置偏移量之前的字符进行查找
$newstring = 'abcdef abcdef';
$pos = strpos($newstring, 'a', 1); // $pos = 7, 不是 0
//>>63.stripos() 等同于 strpos()（不区分大小写）

//>>64.int strrpos ( string $haystack , string $needle [, int $offset = 0 ] )计算指定字符串在目标字符串中最后一次出现的位置
$foo = "0123456789a123456789b123456789c";
var_dump(strrpos($foo, '7', -5));  // 从尾部第 5 个位置开始查找// 结果: int(17)
var_dump(strrpos($foo, '7', 20));  // 从第 20 个位置开始查找// 结果: int(27)
var_dump(strrpos($foo, '7', 28));  // 结果: bool(false)
//>>65.strripos() 等同于 strrpos() （不区分大小写）

//>>66.int strspn ( string $subject , string $mask [, int $start [, int $length ]] )计算字符串中全部字符都存在于指定字符集合中的第一段子串的长度
//返回 subject 中全部字符仅存在于 mask 中的第一组连续字符(子字符串)的长度。
//$mask 没有数序要求 只是代表每一个的字符是否在字符串出现过的连续长度
//>>67.int strcspn ( string $str1 , string $str2 [, int $start [, int $length ]] ) 获取不匹配遮罩的起始子字符串的长度
//返回 str1 中，所有字符都不存在于 str2 范围的起始子字符串的长度。

//>>68.mixed str_word_count ( string $string [, int $format = 0 [, string $charlist ]] )返回字符串中单词的使用情况
//返回一个数组或整型数，这取决于 format 参数的选择。

//>>69.int strlen ( string $string ) 获取字符串长度    --返回给定的字符串 string 的长度。
//>>70.mixed count_chars ( string $string [, int $mode = 0 ] )返回字符串所用字符的信息
//统计 string 中每个字节值（0..255）出现的次数，使用多种模式返回结果。

//>>71.md5()
//>>72.array()
//>>73.array array_combine ( array $keys , array $values )array_combine — 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
//返回一个 array，用来自 keys 数组的值作为键名，来自 values 数组的值作为相应的值
//>>74.array range ( mixed $start , mixed $end [, number $step = 1 ] )根据范围创建数组，包含指定的元素

//>>75.array compact ( mixed $varname1 [, mixed $... ] )建立一个数组，包括变量名和它们的值
$city  = "San Francisco";
$state = "CA";
$event = "SIGGRAPH";
$location_vars = array("city", "state");
$result = compact("event", "nothing_here", $location_vars);
print_r($result);
//以上例程会输出：
/*Array
(
[event] => SIGGRAPH
[city] => San Francisco
[state] => CA
)*/

//>>76.array array_fill ( int $start_index , int $num , mixed $value )用给定的值填充数组
//array_fill() 用 value 参数的值将一个数组填充 num 个条目，键名由 start_index 参数指定的开始。
//Example #1 array_fill() 例子
$a = array_fill(5, 6, 'banana');
$b = array_fill(-2, 4, 'pear');
print_r($a);
print_r($b);
//以上例程会输出：
/*Array
(
[5]  => banana
[6]  => banana
[7]  => banana
[8]  => banana
[9]  => banana
[10] => banana
)
Array
(
[-2] => pear
[0] => pear
[1] => pear
[2] => pear
)*/

//>>77.array array_chunk ( array $array , int $size [, bool $preserve_keys = false ] )//将一个数组分割成多个
//将一个数组分割成多个数组，其中每个数组的单元数目由 size 决定。最后一个数组的单元数目可能会少于 size 个。
$input_array = array('a', 'b', 'c', 'd', 'e');
print_r(array_chunk($input_array, 2));
/**
Array(
[0] => Array([0] => a,[1] => b)
[1] => Array([0] => c,[1] => d)
[2] => Array( [0] => e )
)
 **/
//>>78.array array_merge ( array $array1 [, array $... ] )合并一个或多个数组
//array_merge() 将一个或多个数组的单元合并起来，一个数组中的值附加在前一个数组的后面。返回作为结果的数组。
/**注意:数字索引的会重新排号,关联索引的如果出现同名后面覆盖前面的**/

//>>79.array array_slice ( array $array , int $offset [, int $length = NULL [, bool $preserve_keys = false ]] )  从数组中取出一段
//array_slice() 返回根据 offset 和 length 参数所指定的 array 数组中的一段序列。
/**数组的截取.类似字符串截取函数strstr**/

//>>80.array_diff — 计算数组的差集
//array array_diff ( array $array1 , array $array2 [, array $... ] )
//对比 array1 和其他一个或者多个数字，返回---在 array1 中--但是不在其他 array 里的--值--。

//>>81.array_intersect — 计算数组的交集 (与diff相反)
//array array_intersect ( array $array1 , array $array2 [, array $... ] )
//array_intersect() 返回一个数组，该数组包含了所有在 array1 中也同时出现在所有其它参数数组中的值。注意键名保留不变。

//>>82.array_search — 在数组中搜索给定的值，如果成功则返回首个相应的键名
//mixed array_search ( mixed $needle , array $haystack [, bool $strict = false ] )
//大海捞针，在大海（haystack）中搜索针（ needle 参数）。
////如果 needle 是字符串，则比较以区分大小写的方式进行。

//>>83.array_splice — 去掉数组中的某一部分并用其它值取代
//array array_splice ( array &$input , int $offset  [, int $length = count($input) [, mixed $replacement = array() ]] )
//把 input 数组中由 offset 和 length 指定的单元去掉，如果提供了 replacement 参数，则用其中的单元取代。

//>>84.array_sum — 对数组中所有值求和
//number array_sum ( array $array )
//array_sum() 将数组中的所有值相加，并返回结果。

//>>85.in_array — 检查数组中是否存在某个值
//bool in_array ( mixed $needle , array $haystack [, bool $strict = FALSE ] )

//>>86.array_key_exists — 检查数组里是否有指定的键名或索引
//bool array_key_exists ( mixed $key , array $array )
//数组里有键 key 时，array_key_exists() 返回 TRUE。 key 可以是任何能作为数组索引的值。

//>>87.key — 从关联数组中取得键名
//mixed key ( array &$array )
//key() 返回数组中当前单元的键名。

//>>88.current — 返回数组中的当前单元
//mixed current ( array &$array )
//每个数组中都有一个内部的指针指向它"当前的"单元，初始指向插入到数组中的第一个单元。
$transport = array('foot', 'bike', 'car', 'plane');
$mode = current($transport); // $mode = 'foot';
$mode = next($transport);    // $mode = 'bike';
$mode = current($transport); // $mode = 'bike';
$mode = prev($transport);    // $mode = 'foot';
$mode = end($transport);     // $mode = 'plane';
$mode = current($transport); // $mode = 'plane';

$arr = array();
var_dump(current($arr)); // bool(false)

$arr = array(array());
var_dump(current($arr)); // array(0) { }
/**
 * •end() - 将数组的内部指针指向最后一个单元
•key() - 从关联数组中取得键名
•each() - 返回数组中当前的键／值对并将数组指针向前移动一步
•prev() - 将数组的内部指针倒回一位
•reset() - 将数组的内部指针指向第一个单元
•next() - 将数组中的内部指针向前移动一位
 **/

//>>92.each — 返回数组中当前的键／值对并将数组指针向前移动一步
//array each ( array &$array )
//返回数组中当前的键／值对并将数组指针向前移动一步
//在执行 each() 之后，数组指针将停留在数组中的下一个单元或者当碰到数组结尾时停留在最后一个单元。如果要再用 each 遍历数组，必须使用 reset()。
/**
reset — 将数组的内部指针指向第一个单元
mixed reset ( array &$array )
reset() 将 array 的内部指针倒回到第一个单元并返回第一个数组单元的值。
**/

//>>93.list — 把数组中的值赋给一组变量
//array list ( mixed $var1 [, mixed $... ] )
//像 array() 一样，这不是真正的函数，而是语言结构。 list() 可以在单次操作内就为一组变量赋值。

//>>94.array_shift — 将数组开头的单元移出数组
//mixed array_shift ( array &$array )
//array_shift() 将 array 的第一个单元移出并作为结果返回，将 array 的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变。
/**
array_unshift() - 在数组开头插入一个或多个单元
array_push() - 将一个或多个单元压入数组的末尾（入栈）
array_pop() - 弹出数组最后一个单元（出栈）
 */

//>>98.shuffle — 打乱数组
//bool shuffle ( array &$array )
//本函数打乱（随机排列单元的顺序）一个数组。 它使用的是伪随机数产生器，并不适合密码学的场合。

//>>99.count — 计算数组中的单元数目，或对象中的属性个数
//int count ( mixed $array_or_countable [, int $mode = COUNT_NORMAL ] )
//统计出数组里的所有元素的数量，或者对象里的东西。

//>>100.array_flip — 交换数组中的键和值
//array array_flip ( array $array )
//array_flip() 返回一个反转后的 array，例如 array 中的键名变成了值，而 array 中的值成了键名。
//注意 array 中的值需要能够作为合法的键名（例如需要是 integer 或者 string）。如果类型不对，将出现一个警告，并且有问题的键／值对将不会出现在结果里。
//如果同一个值出现多次，则最后一个键名将作为它的值，其它键会被丢弃。

//>>101.array_keys — 返回数组中部分的或所有的键名
//array array_keys ( array $array [, mixed $search_value = null [, bool $strict = false ]] )
//array_keys() 返回 input 数组中的数字或者字符串的键名。

//>>102.array_values — 返回数组中所有的值
//array array_values ( array $array )
//array_values() 返回 input 数组中所有的值并给其建立数字索引。

//>>103.array_reverse — 返回单元顺序相反的数组  (reverse:相反,颠倒)
//array array_reverse ( array $array [, bool $preserve_keys = false ] )
//array_reverse() 接受数组 array 作为输入并返回一个单元为相反顺序的新数组。

//>>104.array_count_values — 统计数组中所有的值
//array array_count_values ( array $array  )
//array_count_values() 返回一个数组： 数组的键是 array 里单元的值； 数组的值是 array 单元的值出现的次数。
/**
count() - 计算数组中的单元数目，或对象中的属性个数
array_unique() - 移除数组中重复的值
array_values() - 返回数组中所有的值
count_chars() - 返回字符串所用字符的信息
 */

//>>105.array_rand — 从数组中随机取出一个或多个单元
//mixed array_rand ( array $array [, int $num = 1 ] )
//从数组中取出一个或多个随机的单元，并返回随机条目的一个或多个键。 它使用了伪随机数产生算法，所以不适合密码学场景

//>>106.each — 返回数组中当前的键／值对并将数组指针向前移动一步
//array each ( array &$array )
//返回数组中当前的键／值对并将数组指针向前移动一步
//在执行 each() 之后，数组指针将停留在数组中的下一个单元或者当碰到数组结尾时停留在最后一个单元。如果要再用 each 遍历数组，必须使用 reset()。

//>>107.array_unique — 移除数组中重复的值
//array array_unique ( array $array [, int $sort_flags = SORT_STRING ] )
//array_unique() 接受 array 作为输入并返回没有重复值的新数组。
//注意键名保留不变。array_unique() 先将值作为字符串排序，然后对每个值只保留第一个遇到的键名，接着忽略所有后面的键名。这并不意味着在未排序的 array 中同一个值的第一个出现的键名会被保留。
/**
array
    输入的数组。
sort_flags
    第二个可选参数sort_flags 可用于修改排序行为：
排序类型标记：
    • SORT_REGULAR - 按照通常方法比较（不修改类型）
    • SORT_NUMERIC - 按照数字形式比较
    • SORT_STRING - 按照字符串形式比较
    • SORT_LOCALE_STRING - 根据当前的本地化设置，按照字符串比较。
 */
//Example #1 array_unique() 例子
$input = array("a" => "green", "red", "b" => "green", "blue", "red");
$result = array_unique($input);
print_r($result);
//以上例程会输出：
/**
Array
(
    [a] => green
    [0] => red
    [1] => blue
)*/
//Example #2 array_unique() 和类型
$input = array(4, "4", "3", 4, 3, "3");
$result = array_unique($input);
var_dump($result);
//以上例程会输出：
/**
array(2) {
    [0] => int(4)
    [2] => string(1) "3"
}
*/

//>>108.sort — 对数组排序 (按值排序.返回索引数组)
//bool sort ( array &$array [, int $sort_flags = SORT_REGULAR ] )
//本函数对数组进行排序。当本函数结束时数组单元将被从最低到最高重新安排。
/**
sort_flags
    可选的第二个参数 sort_flags 可以用以下值改变排序的行为：

排序类型标记：
    • SORT_REGULAR - 正常比较单元（不改变类型）
    • SORT_NUMERIC - 单元被作为数字来比较
    • SORT_STRING - 单元被作为字符串来比较
    • SORT_LOCALE_STRING - 根据当前的区域（locale）设置来把单元当作字符串比较，可以用 setlocale() 来改变。
    • SORT_NATURAL - 和 natsort() 类似对每个单元以"自然的顺序"对字符串进行排序。 PHP 5.4.0 中新增的。
    • SORT_FLAG_CASE - 能够与 SORT_STRING 或 SORT_NATURAL 合并（OR 位运算），不区分大小写排序字符串。
 */
//>>109.rsort — 对数组逆向排序(按值倒序,返回索引)
//bool rsort ( array &$array [, int $sort_flags = SORT_REGULAR ] )
//>>110.asort — 对数组进行排序并保持索引关系(按值排序,保持原来的键值对应关系)
//bool asort ( array &$array [, int $sort_flags = SORT_REGULAR ] )
//>>111.arsort — 对数组进行逆向排序并保持索引关系
//>>112.ksort — 对数组按照键名排序(按键名排序)
//bool ksort ( array &$array [, int $sort_flags = SORT_REGULAR ] )
//>>113.krsort — 对数组按照键名逆向排序

//>>114.natsort — 用"自然排序"算法对数组排序
//bool natsort ( array &$array )
//本函数实现了一个和人们通常对字母数字字符串进行排序的方法一样的排序算法并保持原有键／值的关联，这被称为"自然排序"。本算法和通常的计算机字符串排序算法（用于 sort()）的区别见下面示例。
//自然排序:人的习惯 1,2,10,12   电脑习惯: 1,10,12,2
//>>115.natcasesort — 用"自然排序"算法对数组进行不区分大小写字母的排序

//>>116.fopen — 打开文件或者 URL
//resource fopen ( string $filename , string $mode [, bool $use_include_path = false [, resource $context ]] )
//fopen() 将 filename 指定的名字资源绑定到一个流上。
/**
 * 参数
filename
    如果 filename 是 "scheme://..." 的格式，则被当成一个 URL
    如果 PHP 认为 filename 指定的是一个本地文件，将尝试在该文件上打开一个流。该文件必须是 PHP 可以访问的，因此需要确认文件访问权限允许该访问。如果激活了安全模式或者 open_basedir 则会应用进一步的限制。

 * mode
    mode 参数指定了所要求到该流的访问类型。可以是以下：
    'r' 只读方式打开，将文件指针指向文件头。
    'r+' 读写方式打开，将文件指针指向文件头。
    'w' 写入方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
    'w+' 读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
    'a' 写入方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
    'a+' 读写方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
    'x' 创建并以写入方式打开，将文件指针指向文件头。如果文件已存在，则 fopen() 调用失败并返回 FALSE，并生成一条 E_WARNING 级别的错误信息。如果文件不存在则尝试创建之。这和给 底层的 open(2) 系统调用指定 O_EXCL|O_CREAT 标记是等价的
    'x+'
    'c'
    'c+'
 */
/**
 * 参见
•支持的协议和封装协议
•fclose() - 关闭一个已打开的文件指针
•fgets() - 从文件指针中读取一行
•fread() - 读取文件（可安全用于二进制文件）
•fwrite() - 写入文件（可安全用于二进制文件）
•fsockopen() - 打开一个网络连接或者一个Unix套接字连接
•file() - 把整个文件读入一个数组中
•file_exists() - 检查文件或目录是否存在
•is_readable() - 判断给定文件名是否可读
•stream_set_timeout() - Set timeout period on a stream
•popen() - 打开进程文件指针
•stream_context_create() - 创建资源流上下文
•umask() - 改变当前的 umask
•SplFileObject
 */

//>>117.fclose — 关闭一个已打开的文件指针 文件指针必须有效，并且是通过 fopen() 或 fsockopen() 成功打开的。

//>>118.file_exists — 检查文件或目录是否存在
//bool file_exists ( string $filename )
//检查文件或目录是否存在。
/**is_file is_dir**/
//Example #1 测试一个文件是否存在
$filename = '/path/to/foo.txt';
if (file_exists($filename)) {
    echo "The file $filename exists";
} else {
    echo "The file $filename does not exist";
}

//>>119.filesize — 取得文件大小
//int filesize ( string $filename )
//取得指定文件的大小。 /**getimagesize()获取图片类型和大小**/

// 输出类似：somefile.txt: 1024 bytes
$filename = 'somefile.txt';
echo $filename . ': ' . filesize($filename) . ' bytes';

//>>120.is_readable — 判断给定文件名是否可读
//bool is_readable ( string $filename )
//判断给定文件名是否存在并且可读。
//>>121.is_writable — 判断给定的文件名是否可写
//bool isset ( mixed $var [, mixed $... ] )
//>>122.is_executable — 判断给定文件名是否可执行
//bool is_executable ( string $filename )

//>>123.filectime — 取得文件的 inode 修改时间
//int filectime ( string $filename )
//取得文件的 inode 修改时间。
//>>124.filemtime — 取得文件修改时间
//>>125.fileatime — 取得文件的上次访问时间

//>>126.stat — 给出文件的信息
//说明
//array stat ( string $filename )
//获取由 filename 指定的文件的统计信息。如果 filename 是符号连接，则统计信息是关于被连接文件本身的，而不是符号连接。
//lstat() 和 stat() 相同，只除了它会返回符号连接的状态。
/**
 * 返回值
stat() 和 fstat() 返回格式
数字下标
关联键名（自 PHP 4.0.6）
说明
0 dev device number - 设备名
1 ino inode number - inode 号码
2 mode inode protection mode - inode 保护模式
3 nlink number of links - 被连接数目
4 uid userid of owner - 所有者的用户 id
5 gid groupid of owner- 所有者的组 id
6 rdev device type, if inode device * - 设备类型，如果是 inode 设备的话
7 size size in bytes - 文件大小的字节数
8 atime time of last access (unix timestamp) - 上次访问时间（Unix 时间戳）
9 mtime time of last modification (unix timestamp) - 上次修改时间（Unix 时间戳）
10 ctime time of last change (unix timestamp) - 上次改变时间（Unix 时间戳）
11 blksize blocksize of filesystem IO * - 文件系统 IO 的块大小
12 blocks number of blocks allocated - 所占据块的数目
 * Windows 下总是 0。
 * - 仅在支持 st_blksize 类型的系统下有效。其它系统（如 Windows）返回 -1。
如果出错，stat() 返回 FALSE。
 */

//>>127.fwrite — 写入文件（可安全用于二进制文件）
//说明
//int fwrite ( resource $handle , string $string [, int $length ] )
//fwrite() 把 string 的内容写入 文件指针 handle 处。
/**
范例
Example #1 一个简单的 fwrite() 例子
*/
$filename = 'test.txt';
$somecontent = "添加这些文字到文件\n";
// 首先我们要确定文件存在并且可写。
if (is_writable($filename)) {
    // 在这个例子里，我们将使用添加模式打开$filename，
    // 因此，文件指针将会在文件的末尾，
    // 那就是当我们使用fwrite()的时候，$somecontent将要写入的地方。
    if (!$handle = fopen($filename, 'a')) {
        echo "不能打开文件 $filename";
        exit;
    }

    // 将$somecontent写入到我们打开的文件中。
    if (fwrite($handle, $somecontent) === FALSE) {
        echo "不能写入到文件 $filename";
        exit;
    }

    echo "成功地将 $somecontent 写入到文件$filename";

    fclose($handle);

} else {
    echo "文件 $filename 不可写";
}
//>>128.fputs — fwrite() 的别名
//>>129.fread — 读取文件（可安全用于二进制文件）
//string fread ( resource $handle , int $length )
//fread() 从文件指针 handle 读取最多 length 个字节。 该函数在遇上以下几种情况时停止读取文件：
//•  读取了 length 个字节
//•  到达了文件末尾（EOF）
$filename = "/usr/local/something.txt";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
//在区分二进制文件和文本文件的系统上（如 Windows）打开文件时，fopen() 函数的 mode 参数要加上 'b'。
//如:$handle = fopen($filename, "rb");

//>>130.feof — 测试文件指针是否到了文件结束的位置
//bool feof ( resource $handle )
//测试文件指针是否到了文件结束的位。
//返回值
//如果文件指针到了 EOF 或者出错时则返回 TRUE，否则返回一个错误（包括 socket 超时），其它情况则返回 FALSE。
//注释
//Warning
//如果服务器没有关闭由 fsockopen() 所打开的连接，feof() 会一直等待直到超时。要解决这个问题可参见以下范例：
//Example #1 处理 feof() 的超时
function safe_feof($fp, &$start = NULL) {
    $start = microtime(true);
    return feof($fp);
}
/* $fp 的赋值是由之前 fsockopen() 打开  */
$start = NULL;
$timeout = ini_get('default_socket_timeout');
while(!safe_feof($fp, $start) && (microtime(true) - $start) < $timeout)
{
    /* Handle */
}
//    Warning
//    如果传递的文件指针无效可能会陷入无限循环中，因为 feof() 不会返回 TRUE。
//    Example #2 使用无效文件指针的 feof() 例子
// 如果文件不可读取或者不存在，fopen 函数返回 FALSE
$file = @fopen("no_such_file", "r");
// 来自 fopen 的 FALSE 会发出一条警告信息并在这里陷入无限循环
while (!feof($file)) {
}
fclose($file);

//>>131.fgets — 从文件指针中读取一行
//string fgets ( resource $handle [, int $length ] )
//从文件指针中读取一行。
//length
//  从 handle 指向的文件中读取一行并返回长度最多为 length - 1 字节的字符串。碰到换行符（包括在返回值中）、EOF 或者已经读取了 length - 1 字节后停止（看先碰到那一种情况）。如果没有指定 length，则默认为 1K，或者说 1024 字节。
//fgetss() - 从文件指针中读取一行并过滤掉 HTML 标记

//>>132.fgetc — 从文件指针中读取字符 (这个是从文件中一个字符一个字符的读取)
//string fgetc ( resource $handle )
//从文件句柄中获取一个字符。
//返回一个包含有一个字符的字符串，该字符从 handle 指向的文件中得到。 碰到 EOF 则返回 FALSE。

//>>133.file — 把整个文件读入一个数组中
//array file ( string $filename [, int $flags = 0 [, resource $context ]] )
//把整个文件读入一个数组中。
//你可以通过 file_get_contents() 以字符串形式获取文件的内容。
/**
 * filename
文件的路径。
Tip
如已启用fopen 包装器，在此函数中， URL 可作为文件名。关于如何指定文件名详见 fopen()。各种 wapper 的不同功能请参见 支持的协议和封装协议，注意其用法及其可提供的预定义变量。
flags
可选参数 flags 可以是以下一个或多个常量：
FILE_USE_INCLUDE_PATH 在 include_path 中查找文件。  FILE_IGNORE_NEW_LINES 在数组每个元素的末尾不要添加换行符  FILE_SKIP_EMPTY_LINES 跳过空行
context
A context resource created with the stream_context_create() function.

Note: 在 PHP 5.0.0 中增加了对上下文（Context）的支持。有关上下文（Context）的说明参见 Streams。
 */

//>>134.readfile — 输出文件
//int readfile ( string $filename [, bool $use_include_path = false [, resource $context ]] )
//读取文件并写入到输出缓冲。
//参数
/**
filename
要读取的文件名。
use_include_path
想要在 include_path 中搜索文件，可使用这个可选的第二个参数，设为 TRUE。
context
Stream 上下文（context） resource。
返回值
返回从文件中读入的字节数。如果出错返回 FALSE 并且除非是以 @readfile() 形式调用，否则会显示错误信息。
范例
Example #1 使用 readfile() 强制下载
*/
$file = 'monkey.gif';
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

//>>135.file_get_contents — 将整个文件读入一个字符串
//string file_get_contents ( string $filename [, bool $use_include_path = false [, resource $context [, int $offset = -1 [, int $maxlen ]]]] )
//和 file() 一样，只除了 file_get_contents() 把文件读入一个字符串。将在参数 offset 所指定的位置开始读取长度为 maxlen 的内容。如果失败，file_get_contents() 将返回 FALSE。

//>>136.file_put_contents — 将一个字符串写入文件
//int file_put_contents ( string $filename , mixed $data [, int $flags = 0 [, resource $context ]] )
//和依次调用 fopen()，fwrite() 以及 fclose() 功能一样。
$file = 'people.txt';
// The new person to add to the file
$person = "John Smith\n";
// Write the contents to the file,
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents($file, $person, FILE_APPEND | LOCK_EX);

//>>137.ftell — 返回文件指针读/写的位置
//int ftell ( resource $handle )
//返回由 handle 指定的文件指针的位置，也就是文件流中的偏移量。
// opens a file and read some data
$fp = fopen("/etc/passwd", "r");
$data = fgets($fp, 12);
// where are we ?
echo ftell($fp); // 11
fclose($fp);

//>>138.fseek — 在文件指针中定位
//int fseek ( resource $handle , int $offset [, int $whence = SEEK_SET ] )
//在与 handle 关联的文件中设定文件指针位置。 新位置从文件头开始以字节数度量，是以 whence 指定的位置加上 offset。
//offset
//偏移量。
//要移动到文件尾之前的位置，需要给 offset 传递一个负值，并设置 whence 为 SEEK_END

//>>139.rewind — 倒回文件指针的位置(到开头---除了a   a+)
//bool rewind ( resource $handle )
//将 handle 的文件位置指针设为文件流的开头。
//范例
//Example #1 rewind() overwriting example
$handle = fopen('output.txt', 'r+');
fwrite($handle, 'Really long sentence.');
rewind($handle);
fwrite($handle, 'Foo');
rewind($handle);
echo fread($handle, filesize('output.txt'));
fclose($handle);
//以上例程的输出类似于：
//Foolly long sentence.

//>>140.flock — 轻便的咨询    文件锁定
//bool flock ( resource $handle , int $operation [, int &$wouldblock ] )
//flock() 允许执行一个简单的可以在任何平台中使用的读取/写入模型（包括大部分的 Unix 派生版和甚至是 Windows）。

//>>141.basename — 返回路径中的文件名部分
//string basename ( string $path [, string $suffix ] )
//给出一个包含有指向一个文件的全路径的字符串，本函数返回基本的文件名。
echo "1) ".basename("/etc/sudoers.d", ".d").PHP_EOL;
echo "2) ".basename("/etc/passwd").PHP_EOL;
echo "3) ".basename("/etc/").PHP_EOL;
echo "4) ".basename(".").PHP_EOL;
echo "5) ".basename("/");
//以上例程会输出：
//1) sudoers
//2) passwd
//3) etc
//4) .
//5)

//>>142.dirname — 返回路径中的目录部分
//string dirname ( string $path )
//给出一个包含有指向一个文件的全路径的字符串，本函数返回去掉文件名后的目录名。
echo "1) " . dirname("/etc/passwd") . PHP_EOL; // 1) /etc
echo "2) " . dirname("/etc/") . PHP_EOL; // 2) / (or \ on Windows)
echo "3) " . dirname("."); // 3) .

//>>143.pathinfo — 返回文件路径的信息
//mixed pathinfo ( string $path [, int $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME ] )
//pathinfo() 返回一个关联数组包含有 path 的信息。返回关联数组还是字符串取决于 options。
$path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
echo $path_parts['dirname'], "\n";
echo $path_parts['basename'], "\n";
echo $path_parts['extension'], "\n";
echo $path_parts['filename'], "\n"; // since PHP 5.2.0
//以上例程会输出：
//      /www/htdocs/inc
//      lib.inc.php
//      php
//      lib.inc

//>>144.opendir — 打开目录句柄
//resource opendir ( string $path [, resource $context ] )
//打开一个目录句柄，可用于之后的 closedir()，readdir() 和 rewinddir() 调用中。
//Example #1 opendir() 例子
$dir = "/etc/php5/";
// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";//拼接目录
        }
        closedir($dh);
    }
}
//以上例程的输出类似于：
//      filename: . : filetype: dirtt
//      filename: .. : filetype: dir
//      filename: apache : filetype: dir
//      filename: cgi : filetype: dir
//      filename: cli : filetype: dir
/**
 * 扩展
 * readdir — 从目录句柄中读取条目
filetype — 取得文件类型
string filetype ( string $filename )
返回文件的类型。
echo filetype('/etc/passwd');  // file
echo filetype('/etc/');        // dir
 */

//>>145.readdir — 从目录句柄中读取条目
//string readdir ([ resource $dir_handle ] )
//返回目录中下一个文件的文件名。文件名以在文件系统中的排序返回。
/**
返回值
成功则返回文件名 或者在失败时返回 FALSE
Warning
此函数可能返回布尔值 FALSE，但也可能返回等同于 FALSE 的非布尔值。请阅读 布尔类型章节以获取更多信息。应使用 === 运算符来测试此函数的返回值。
范例
Example #1 列出目录中的所有文件
请留意下面例子中检查 readdir() 返回值的风格。这里明确地测试返回值是否全等于（值和类型都相同——更多信息参见比较运算符）FALSE，否则任何目录项的名称求值为 FALSE 的都会导致循环停止（例如一个目录名为"0"）。
*/
// 注意在 4.0.0-RC2 之前不存在 !== 运算符
if ($handle = opendir('/path/to/files')) {
    echo "Directory handle: $handle\n";
    echo "Files:\n";

    /* 这是正确地遍历目录方法 */
    while (false !== ($file = readdir($handle))) {
        echo "$file\n";
    }

    /* 这是错误地遍历目录的方法 */
    while ($file = readdir($handle)) { //错错错错的方法!!!!!
        echo "$file\n";
    }

    closedir($handle);
}
//    Example #2 列出当前目录的所有文件并去掉 . 和 ..
if ($handle = opendir('.')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            echo "$file\n"; //输出 下一  级的目录,写个方法用递归可以输出所有目录
        }
    }
    closedir($handle);
}

//>>146.closedir — 关闭目录句柄
//void closedir ([ resource $dir_handle ] )
//关闭由 dir_handle 指定的目录流。流必须之前被 opendir() 所打开。
//目录句柄的 resource，之前由 opendir() 所打开的。如果目录句柄没有指定，那么会假定为是opendir()所打开的最后一个句柄。

//>>147.rewinddir — 倒回目录句柄
//void rewinddir ( resource $dir_handle )
//将 dir_handle 指定的目录流重置到目录的开头。

//>>148.mkdir — 新建目录
//bool mkdir ( string $pathname [, int $mode = 0777 [, bool $recursive = false [, resource $context ]]] )
//尝试新建一个由 pathname 指定的目录。
// Desired folder structure
$structure = './depth1/depth2/depth3/';
// To create the nested structure, the $recursive parameter
// to mkdir() must be specified.
if (!is_dir($structure)){
    mkdir($structure, 0777, true);
}
//if (!mkdir($structure, 0, true)) {
//    die('Failed to create folders...');
//}

//>>149.rmdir — 删除目录
//bool rmdir ( string $dirname [, resource $context ] )
//尝试删除 dirname 所指定的目录。 该目录必须是空的，而且要有相应的权限。 失败时会产生一个 E_WARNING 级别的错误。
if (is_dir('examples')) {
    rmdir('examples');
}

//>>150.unlink — 删除文件
//bool unlink ( string $filename [, resource $context ] )
//删除 filename。和 Unix C 的 unlink() 函数相似。 发生错误时会产生一个 E_WARNING 级别的错误。

//>>151.copy — 拷贝文件
//bool copy ( string $source , string $dest [, resource $context ] )
//将文件从 source 拷贝到 dest。
//如果要移动文件的话，请使用 rename() 函数。

//>>152.rename — 重命名一个文件或目录
//bool rename ( string $oldname , string $newname [, resource $context ] )
//尝试把 oldname 重命名为 newname。
rename("/tmp/tmp_file.txt", "/home/user/login/docs/my_file.txt");

//>>153.is_uploaded_file — 判断文件是否是通过 HTTP POST 上传的
//说明
//bool is_uploaded_file ( string $filename )
//如果 filename 所给出的文件是通过 HTTP POST 上传的则返回 TRUE。这可以用来确保恶意的用户无法欺骗脚本去访问本不能访问的文件，例如 /etc/passwd。
//这种检查显得格外重要，如果上传的文件有可能会造成对用户或本系统的其他用户显示其内容的话。
//为了能使 is_uploaded_file() 函数正常工作，必段指定类似于 $_FILES['userfile']['tmp_name'] 的变量，而在从客户端上传的文件名 $_FILES['userfile']['name'] 不能正常运作。
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    echo "File ". $_FILES['userfile']['name'] ." uploaded successfully.\n";
    echo "Displaying contents\n";
    readfile($_FILES['userfile']['tmp_name']);
} else {
    echo "Possible file upload attack: ";
    echo "filename '". $_FILES['userfile']['tmp_name'] . "'.";
}

//>>154.move_uploaded_file — 将上传的文件移动到新位置
//bool move_uploaded_file ( string $filename , string $destination )
//本函数检查并确保由 filename 指定的文件是合法的上传文件（即通过 PHP 的 HTTP POST 上传机制所上传的）。如果文件合法，则将其移动为由 destination 指定的文件。
//这种检查显得格外重要，如果上传的文件有可能会造成对用户或本系统的其他用户显示其内容的话。
$uploads_dir = '/uploads';
foreach ($_FILES["pictures"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
        $name = $_FILES["pictures"]["name"][$key];
        move_uploaded_file($tmp_name, "$uploads_dir/$name");
    }
}

//>>155.time — 返回当前的 Unix 时间戳
//int time ( void )
//返回自从 Unix 纪元（格林威治时间 1970 年 1 月 1 日 00:00:00）到当前时间的秒数。
$nextWeek = time() + (7 * 24 * 60 * 60);
// 7 days; 24 hours; 60 mins; 60 secs
echo 'Now:       '. date('Y-m-d') ."\n";
echo 'Next Week: '. date('Y-m-d', $nextWeek) ."\n";
// or using strtotime():
echo 'Next Week: '. date('Y-m-d', strtotime('+1 week')) ."\n";
//以上例程的输出类似于：
//Now:       2005-03-30
//Next Week: 2005-04-06
//Next Week: 2005-04-06
echo strtotime("now"), "\n";
echo strtotime("10 September 2000"), "\n";
echo strtotime("+1 day"), "\n";
echo strtotime("+1 week"), "\n";
echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
echo strtotime("next Thursday"), "\n";
echo strtotime("last Monday"), "\n";
/**
 * Relative Formats  strtotime()的相对时间格式的字符串表现形式,详情查手册
 */

//>>156.mktime — 取得一个日期的 Unix 时间戳
//int mktime ([ int $hour = date("H") [, int $minute = date("i") [, int $second = date("s") [, int $month = date("n") [, int $day = date("j") [, int $year = date("Y") [, int $is_dst = -1 ]]]]]]] )
//根据给出的参数返回 Unix 时间戳。时间戳是一个长整数，包含了从 Unix 纪元（January 1 1970 00:00:00 GMT）到给定时间的秒数。
//参数可以从右向左省略，任何省略的参数会被设置成本地日期和时间的当前值。

//返回值
//mktime() 根据给出的参数返回 Unix 时间戳。如果参数非法，本函数返回 FALSE（在 PHP 5.1 之前返回 -1）。
//错误／异常
//在每 次调用日期/时间函数时，如果时区无效则会引发 E_NOTICE 错误，如果使用系统设定值或 TZ 环境变量，则会引发 E_STRICT 或 E_WARNING 消息。参见 date_default_timezone_set()。
//更新日志
//说明
//7.0.0 is_dst参数已经被移除。
//5.3.0 mktime() now throws E_DEPRECATED notice if the is_dst parameter is used.
//5.1.0 is_dst 参数被废弃。出错时函数返回 FALSE 而不再是 -1。修正了本函数可以接受年月日参数全为零。
//5.1.0 When called with no arguments, mktime() throws E_STRICT notice. Use the time() function instead.
//5.1.0
//现在发布 E_STRICT 和 E_NOTICE 时区错误。
//范例
//Example #1 基本例子
// Set the default timezone to use. Available as of PHP 5.1
date_default_timezone_set('PRC');

// Prints: July 1, 2000 is on a Saturday
echo "July 1, 2000 is on a " . date("l", mktime(0, 0, 0, 7, 1, 2000));

// Prints something like: 2006-04-05T01:02:03+00:00
echo date('c', mktime(1, 2, 3, 4, 5, 2006));

//    Example #2 mktime() 例子
//    mktime() 在做日期计算和验证方面很有用，它会自动计算超出范围的输入的正确值。例如下面例子中每一行都会产生字符串 "Jan-01-1998"。
echo date("M-d-Y", mktime(0, 0, 0, 12, 32, 1997));
echo date("M-d-Y", mktime(0, 0, 0, 13, 1, 1997));
echo date("M-d-Y", mktime(0, 0, 0, 1, 1, 1998));
echo date("M-d-Y", mktime(0, 0, 0, 1, 1, 98));

//    Example #3 下个月的最后一天
//    任何给定月份的最后一天都可以被表示为下个月的第 "0" 天，而不是 -1 天。下面两个例子都会产生字符串 "The last day in Feb 2000 is: 29"。
$lastday = mktime(0, 0, 0, 3, 0, 2000);
echo strftime("Last day in Feb 2000 is: %d", $lastday);
$lastday = mktime(0, 0, 0, 4, -31, 2000);
echo strftime("Last day in Feb 2000 is: %d", $lastday);

//>>157.checkdate — 验证一个格里高里日期
//bool checkdate ( int $month , int $day , int $year )
//检查由参数构成的日期的合法性。如果每个参数都正确定义了则会被认为是有效的。

var_dump(checkdate(12, 31, 2000));
var_dump(checkdate(2, 29, 2001));
//以上例程会输出：
//bool(true)
//bool(false)

//>>158.date_default_timezone_set — 设定用于一个脚本中所有日期时间函数的默认时区
//bool date_default_timezone_set ( string $timezone_identifier )
//date_default_timezone_set() 设定用于所有日期时间函数的默认时区。
date_default_timezone_set('America/Los_Angeles');
$script_tz = date_default_timezone_get();
if (strcmp($script_tz, ini_get('date.timezone'))){
    echo 'Script timezone differs from ini-set timezone.';
} else {
    echo 'Script timezone and ini-set timezone match.';
}
//string date_default_timezone_get ( void )

//>>159.getdate — 取得日期／时间信息
//array getdate ([ int $timestamp = time() ] )
//返回一个根据 timestamp 得出的包含有日期信息的关联数组 array。如果没有给出时间戳则认为是当前本地时间。
$today = getdate();
print_r($today);
//以上例程的输出类似于：
//Array
//(
//[seconds] => 40
//[minutes] => 58
//[hours]   => 21
//[mday]    => 17
//[wday]    => 2
//[mon]     => 6
//[year]    => 2003
//[yday]    => 167
//[weekday] => Tuesday
//[month]   => June
//[0]       => 1055901520
//)

//>>160.strtotime — 将任何字符串的日期时间描述解析为 Unix 时间戳
//int strtotime ( string $time [, int $now = time() ] )
echo strtotime("now"), "\n";
echo strtotime("10 September 2000"), "\n";
echo strtotime("+1 day"), "\n";
echo strtotime("+1 week"), "\n";
echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
echo strtotime("next Thursday"), "\n";
echo strtotime("last Monday"), "\n";
//    Example #2 失败检查
$str = 'Not Good';
// previous to PHP 5.1.0 you would compare with -1, instead of false
if (($timestamp = strtotime($str)) === false) {
    echo "The string ($str) is bogus";
} else {
    echo "$str == " . date('l dS of F Y h:i:s A', $timestamp);
}

//>>161.microtime — 返回当前 Unix 时间戳和微秒数
//说明
//mixed microtime ([ bool $get_as_float ] )
//microtime() 当前 Unix 时间戳以及微秒数。本函数仅在支持 gettimeofday() 系统调用的操作系统下可用。
$start_time = microtime(true);
for ($i=1;$i<=500;++$i){

}  // usleep()以指定的微秒数延迟执行1微秒（micro second）是百万分之一秒
$end_time = microtime(true);
$effic = $end_time-$start_time;
var_dump($effic);

//>>162.intval — 获取变量的整数值
//说明
//int intval ( mixed $var [, int $base = 10 ] )
//通过使用指定的进制 base 转换（默认是十进制），返回变量 var 的 integer 数值。 intval() 不能用于 object，否则会产生 E_NOTICE 错误并返回 1。
/**参数
var
要转换成 integer 的数量值
base
转化所使用的进制
Note:
如果 base 是 0，通过检测 var 的格式来决定使用的进制：
•  如果字符串包括了 "0x" (或 "0X") 的前缀，使用 16 进制 (hex)；否则，
•  如果字符串以 "0" 开始，使用 8 进制(octal)；否则，
•  将使用 10 进制 (decimal)。
*/
//返回值
//成功时返回 var 的 integer 值，失败时返回 0。 空的 array 返回 0，非空的 array 返回 1。
//最大的值取决于操作系统。 32 位系统最大带符号的 integer 范围是 -2147483648 到 2147483647。举例，在这样的系统上， intval('1000000000000') 会返回 2147483647。64 位系统上，最大带符号的 integer 值是 9223372036854775807。
//字符串有可能返回 0，虽然取决于字符串最左侧的字符。 使用 整型转换 的共同规则。
//范例
//Example #1 intval() 例子
//下面的例子运行于 32 位系统上。
echo intval(42);                      // 42
echo intval(4.2);                     // 4
echo intval('42');                    // 42
echo intval('+42');                   // 42
echo intval('-42');                   // -42
echo intval(042);                     // 34
echo intval('042');                   // 42
echo intval(1e10);                    // 1410065408
echo intval('1e10');                  // 1
echo intval(0x1A);                    // 26
echo intval(42000000);                // 42000000
echo intval(420000000000000000000);   // 0
echo intval('420000000000000000000'); // 2147483647
echo intval(42, 8);                   // 42  除非 var 是一个字符串，否则 base 不会起作用
echo intval('42', 8);                 // 34  除非 var 是一个字符串，否则 base 不会起作用
echo intval(array());                 // 0
echo intval(array('foo', 'bar'));     // 1
//注释
//Note:
/**除非 var 是一个字符串，否则 base 不会起作用。*/
//>>>intdiv — 对除法结果取整
//说明
//int intdiv ( int $dividend , int $divisor )
//返回 dividend 除以 divisor 商数的整数部分。

var_dump(intdiv(3, 2));
var_dump(intdiv(-3, 2));
var_dump(intdiv(3, -2));
var_dump(intdiv(-3, -2));
var_dump(intdiv(PHP_INT_MAX, PHP_INT_MAX));
var_dump(intdiv(PHP_INT_MIN, PHP_INT_MIN));
var_dump(intdiv(PHP_INT_MIN, -1));
var_dump(intdiv(1, 0));
//int(1)
//int(-1)
//int(-1)
//int(1)
//int(1)
//int(1)
//Fatal error: Uncaught ArithmeticError: Division of PHP_INT_MIN by -1 is not an integer in %s on line 8
//Fatal error: Uncaught DivisionByZeroError: Division by zero in %s on line 9

