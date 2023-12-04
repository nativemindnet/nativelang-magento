<?php
/**
 * Public alias for the application entry point
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

use Magento\Framework\App\Bootstrap;

//print_r($server);
//die();
//if($_SERVER['HTTP_HOST']=="market.cpaclub.asia") $_SERVER['HTTP_HOST']="139.84.164.102";
//if($_SERVER['SERVER_NAME']=="market.cpaclub.asia") $_SERVER['SERVER_NAME']="139.84.164.102";


try {
    require __DIR__ . '/../app/bootstrap.php';
} catch (\Exception $e) {
    echo <<<HTML
<div style="font:12px/1.35em arial, helvetica, sans-serif;">
    <div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
        <h3 style="margin:0;font-size:1.7em;font-weight:normal;text-transform:none;text-align:left;color:#2f2f2f;">
        Autoload error</h3>
    </div>
    <p>{$e->getMessage()}</p>
</div>
HTML;
    exit(1);
}

include("views_otop.php");

//print_r($domain2store);



if(isset($domain2store[$_SERVER['HTTP_HOST']]))
    $storecode = $domain2store[$_SERVER['HTTP_HOST']];

$params=$_SERVER;
$params[\Magento\Store\Model\StoreManager::PARAM_RUN_CODE] = isset($storecode) ? $storecode : '';
//$params[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = 'store';
//$params[\Magento\Store\Model\StoreManager::PARAM_RUN_TYPE] = 'website';
//echo($storecode);
//die();

$bootstrap = Bootstrap::create(BP, $params);
/** @var \Magento\Framework\App\Http $app */
$app = $bootstrap->createApplication(\Magento\Framework\App\Http::class);
$bootstrap->run($app);

//print_r($_SERVER);