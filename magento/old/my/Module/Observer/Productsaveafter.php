<?php

namespace SoftDevelopment\Module\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ObjectManager;
use SoftDevelopment\Module\Model\Config;

class Productsaveafter implements ObserverInterface{    

    public function execute(\Magento\Framework\Event\Observer $observer) {

        $product = $observer->getProduct();

        // Your logic to do stuff with $product       
        if(!$product->isObjectNew()) {
            //die("Product Already Exist");
        } 
    }
}
