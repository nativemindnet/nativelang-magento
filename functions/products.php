<?php

function translateProducts($websiteId)
{
    global $objectManager;
    global $storeIds;

    $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory')->create();
    $productCollection->addAttributeToSelect('*');
    $productCollection->addWebsiteFilter($websiteId);

    $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

    //$productIds=array(18,19);

    foreach ($productCollection as $product) {
    //    echo("productId=$productId\n");
        $productId=$product->getId();
    //        if (!(in_array($productId,$productIds))) continue;
    //        if ($productId<15) continue;
        $originalName = $product->getName();
        $originalDescription = $product->getDescription();
        echo("productId=$productId\n");
        echo("originalName=$originalName\n");
        echo("originalDescription=$originalDescription\n");
    //    continue;


        foreach ($product->getStoreIds() as $storeId) {
            if (!(in_array($storeId,$storeIds))) continue;
            echo("storeId=$storeId\n");
            //$locale=$product->getStore()->getLocaleCode();
            $store = $objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)->getStore($storeId);

            $locale=getLocale($storeId);
            echo("locale=$locale\n");

            $product->setStoreId($storeId)->load($product->getId());


            // Use Google Translate API to translate the product name and description
            $translatedName = translateText($originalName, $locale);
            $translatedDescription = translateText($originalDescription, $locale);

            // Save the translated product name and description
            productSaveTranslation($productId, $storeId, $translatedName ,$translatedDescription);
            //die();
            //$product=$product->setName($translatedName);
            //$product=$product->setDescription($translatedDescription);
            //$product=$product->save($product);
        }
    }
}

function productSave($productId, $storeId, $name, $description)
{
    global $objectManager;

    $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);

    //$product->setName('New Product Name');
    //$product->save();

    $product=$product->setStoreId($storeId);
    $product=$product->setData('use_default_name',false);
    $product=$product->setData('use_default_description',false);
    if($name!="") $product=$product->setName($name);
    if($description!="") $product=$product->setDescription($description);
    $product=$product->save($product);
}

function productSaveTranslation($productId, $storeId, $translated_title, $translated_description)
{
    global $objectManager;

    $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);

    //$product->setName('New Product Name');
    //$product->save();

    $product=$product->setStoreId($storeId);
    $product=$product->setData('translated_title',$translated_title);
    $product=$product->setData('translated_description',$translated_description);
    
    //if($name!="") $product=$product->setName($name);
    //if($description!="") $product=$product->setDescription($description);
    $product=$product->save($product);
}