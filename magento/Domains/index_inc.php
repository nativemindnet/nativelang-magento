<?php

//print_r($server);
//die();
//if($_SERVER['HTTP_HOST']=="market.cpaclub.asia") $_SERVER['HTTP_HOST']="139.84.164.102";
//if($_SERVER['SERVER_NAME']=="market.cpaclub.asia") $_SERVER['SERVER_NAME']="139.84.164.102";


include("views_otop.php");

//print_r($domain2store);

if(isset($domain2store[$_SERVER['HTTP_HOST']]))
    $storecode = $domain2store[$_SERVER['HTTP_HOST']];

if(isset($domain2store[$_SERVER['HTTP_HOST']]))
    $storecode = $domain2store[$_SERVER['HTTP_HOST']];

$params=$_SERVER;
$params[\Magento\Store\Model\StoreManager::PARAM_RUN_CODE] = isset($storecode) ? $storecode : '';
//$params[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = 'store';
//$params[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = 'website';
//echo($storecode);
//die();
$_SERVER=$params;
//print_r($_SERVER);