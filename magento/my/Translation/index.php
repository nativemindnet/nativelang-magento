<?php
use Magento\Framework\App\Bootstrap;

//require __DIR__ . '/../../../../app/bootstrap.php';
require '/bitnami/magento/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

//$storeIds=array(1,2,3,4,5,6,7,8,9,10,13,22,23,24,25,26,27,28,29,30,31,32,33);
//$storeIds=array(13);
//$storeViewsIds=array(2,35);


$storeIds=array(1,2,3,4,5,6,7,8,9,10,13,22,23,24,25,26,27,28,29,30,31,32,33,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,);
//$storeIds=array(1,2,3,4,5,6,7,8,9,10,13,22,23,24,25,26,27,28,29,30,31,32,33,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52);
//6 31 1 4
include("funcs/translateText.php");
include("funcs/slug.php");
include("funcs/categories.php");
include("funcs/products.php");
include("funcs/createGPT.php");



translateProducts(10);
die();

foreach ($storeManager->getStores() as $store) {
    $id=$store->getStoreId();
    echo $id . ",";
}
die();


//$store = $storeManager->getStore($storeId);
//$locale = $store->getConfig('general/locale/code');
//echo('"'.$locale.'";');
//}


//echo(getLocale(50));

translateProducts(10);

//13 10

//translateCategories(757,0,true,true);
//generateCategories(757,0);
//slugCategories(757,2);






/*

ТЕГИАмстердамклубы амстердамалучшие клубы АмстердамаНочные клубы АмстердамаПопулярные ночные клубы в Амстердаме

ТЕГИАмстердамклубы амстердамалучшие клубы АмстердамаНочные клубы АмстердамаПопулярные ночные клубы в Амстердаме

*/