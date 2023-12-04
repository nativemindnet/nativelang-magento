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
include("functions/translateText.php");
include("functions/slug.php");
include("functions/categories.php");
include("functions/products.php");
include("functions/createGPT.php");



translateProducts(10,false,true);
