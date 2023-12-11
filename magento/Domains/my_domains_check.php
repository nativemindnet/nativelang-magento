<?php
use Magento\Framework\App\Bootstrap;

include("my_domains_views.php");

print_r($domain2store);

$_SERVER=array(
    'HTTP_HOST'=>"asficlub.com",
    'REQUEST_URI'=>'/chiangmai/index.php'
);

$host = $_SERVER['HTTP_HOST']; // Получаем имя хоста
$uri = $_SERVER['REQUEST_URI']; // Получаем путь URL
$parts = explode('/', $uri);
$firstFolder = isset($parts[1]) ? $parts[1] : ''; // Если папки нет, то будет пустая строка
array_shift($parts);
array_shift($parts);
$withoutFirstFolder = '/' . implode('/', $parts);

//echo "Имя хоста: $host<br>";
//echo "Первая папка: $firstFolder";

$host2=$host."/".$firstFolder;

if(isset($alias2domain[$host2]))
    $host2 = $alias2domain[$host2];

if(isset($domain2store[$host]))
    $storecode = $domain2store[$host];

if(isset($domain2store[$host2]))
{
    $storecode = $domain2store[$host2];
    $_SERVER['REQUEST_URI']=$withoutFirstFolder;
}

echo("<!--storecode:".$storecode."-->");
echo("<!--_SERVER['REQUEST_URI']:".$_SERVER['REQUEST_URI']."-->");