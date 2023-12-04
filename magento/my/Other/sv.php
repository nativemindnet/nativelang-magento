<?php
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get(\Magento\Framework\App\State::class);
$state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);

$storeManager = $objectManager->get(\Magento\Store\Model\StoreManagerInterface::class);

foreach ($storeManager->getStores() as $store) {
    $url=$store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
    $surl=$store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK, true);
    $id=$store->getId();

    echo "'".$url ."'=>'".$store->getCode(). "' //" .$id."||". $store->getName() . "||".$surl. "\n";
}