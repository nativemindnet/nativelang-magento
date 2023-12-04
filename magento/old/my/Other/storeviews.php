<?php

use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

/** @var StoreManagerInterface $storeManager */
$storeManager = $objectManager->get(StoreManagerInterface::class);

/** @var Store[] $stores */
$stores = $storeManager->getStores();

foreach ($stores as $store) {
    $storeViewId = $store->getId();
    $baseUrl = $store->getBaseUrl(Store::URL_TYPE_WEB);

    echo "Store View ID: {$storeViewId}\n";
    echo "Base URL: {$baseUrl}\n\n";
}