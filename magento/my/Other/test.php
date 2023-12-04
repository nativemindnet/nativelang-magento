<?php
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$obj = $bootstrap->getObjectManager();

$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

$productId = 100;
$product = $obj->create('Magento\Catalog\Model\Product')->load($productId);
echo "Product Name: " . $product->getName() . "\n";