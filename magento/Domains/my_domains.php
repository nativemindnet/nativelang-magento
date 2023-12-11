<?php
use Magento\Framework\App\Bootstrap;

function checkStoreCode($storecode)
{
    $storeManager = $objectManager->get(StoreManagerInterface::class);
    $storeExists = $storeManager->hasSingleStore() || $storeManager->getStore($storecode)->getId();
    return $storeExists;
}

function getStoreCode() {
    $storecode="";
    include("my_domains_views.php");
    //print_r($domain2store);


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

    //Сверяем, системный ли домен
    if(isset($domains2spec[$firstFolder]))
    {
        return $domains2spec[$firstFolder];
    }

    //Сверяем, системная ли папка
    if(isset($folders2spec[$firstFolder]))
    {
        return $folders2spec[$firstFolder];
    }

    //Смотрим по алиасам (алиас меняем хост)
    if(isset($alias2domain[$host]))
        $host = $alias2domain[$host];

    //Получаем язык
    #domain2lang
    #$lang="";
    if(isset($domain2lang[$host]))
    {
        $lang=$domain2lang[$host];
        $folder="";
        $default_folder=$folders2city[""];

        if(isset($folders2city[$firstFolder]))
        {
            $folder=$folders2city[$firstFolder];
        } else {
            $folder=$default_folder;
        }
        if (checkStoreCode("view_".$folder."_".$lang)) {
            $_SERVER['REQUEST_URI']=$withoutFirstFolder;
            return "view_".$folder."_".$lang;
        }
        if (checkStoreCode("view_".$default_folder."_".$lang)) {
            $_SERVER['REQUEST_URI']=$withoutFirstFolder;
            return "view_".$default_folder."_".$lang;
        }
    }

    return $storecode;
}


$storecode=getStoreCode();
if(in_array($storecode,array("","end","end:domains2spec","end:folders2spec")))
{
    echo("<!--storecode:".$storecode."-->");
    echo("<!--_SERVER['REQUEST_URI']:".$_SERVER['REQUEST_URI']."-->");
    die();
}

$params=$_SERVER;
$params[\Magento\Store\Model\StoreManager::PARAM_RUN_CODE] = isset($storecode) ? $storecode : '';
$bootstrap = Bootstrap::create(BP, $params);
/** @var \Magento\Framework\App\Http $app */
$app = $bootstrap->createApplication(\Magento\Framework\App\Http::class);
$bootstrap->run($app);


//OLD:
//print_r($_SERVER);
//echo($params[\Magento\Store\Model\StoreManager::PARAM_RUN_CODE]);
//$params[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = 'store';
//$params[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = 'website';
//echo("<!--storecode:".$storecode."-->");
//echo("<!--_SERVER['REQUEST_URI']:".$_SERVER['REQUEST_URI']."-->");
