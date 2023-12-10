<?php

/*
Examples
$productIds=array(18,19); - //to work only on this products
storeIds - same for webviews
*/

function translateProducts($force_translated=false, $websiteId=false, $storeIds=false, $productIds=false)
{
    global $objectManager;


    $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory')->create();
    
    if($websiteId!=false) {
        $productCollection->addAttributeToSelect('*');
        $productCollection->addWebsiteFilter($websiteId);
    }

    $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

    

    foreach ($productCollection as $product) {
        $productId=$product->getId();
        echo("productId=$productId\n");

        if($productIds!=false)
            if (!(in_array($productId,$productIds))) continue;

        if ($productId<73) continue;

        $websiteName = $product->getName();
        $websiteDescription = $product->getDescription();
        echo("productId=$productId\n");
        echo("websiteName=$websiteName\n");
        echo("websiteDescription=$websiteDescription\n");
        
        $productJson=Array(
            "title" => getValue($product->getCustomAttribute('title')),
            "subtitle_translated" => getValue($product->getCustomAttribute('subtitle')),
            "short_description_translated" => getValue($product->getCustomAttribute('short_description')),
            "description_translated" => getValue($product->getCustomAttribute('description')),
            "schedule1_translated" => getValue($product->getCustomAttribute('schedule1')),
            "schedule2_translated" => getValue($product->getCustomAttribute('schedule2')),
            "discount_translated" => getValue($product->getCustomAttribute('discount')),
            "city" => "Hua Hin",
            "address" => getValue($product->getCustomAttribute('address')),
            "address_details_translated" => getValue($product->getCustomAttribute('address_details')),

            "phone" => getValue($product->getCustomAttribute('phone')),
            "facebook" => getValue($product->getCustomAttribute('facebook')),
            "instagram" => getValue($product->getCustomAttribute('instagram')),
            "website" => getValue($product->getCustomAttribute('website')),
            "google_maps_url" => getValue($product->getCustomAttribute('google_maps_url')),
            "booking_required" => getValue($product->getCustomAttribute('booking_required')),
            "price_range" => getValue($product->getCustomAttribute('price_range')),
            
        );

        print_r($productJson);

        //      continue;


        foreach ($product->getStoreIds() as $storeId) {
            if($storeIds!=false)
                if (!(in_array($storeId,$storeIds))) continue;

            echo("storeId=$storeId\n");


    
            //$locale=$product->getStore()->getLocaleCode();
            $store = $objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)->getStore($storeId);

            $locale=getLocale($storeId);
            echo("locale=$locale\n");

            $productJSON_translated=translateProductJson($productJson,$locale,false);
            print_r($productJSON_translated);

            productSaveTranslatedJSON($productId, $storeId, $productJSON_translated);
        }
    }
}

function getValue($attribute)
{
    if ($attribute!==null) return $attribute->getValue();
    return "";
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

function productSaveTranslatedTitle($productId, $storeId, $translated_title)
{
    global $objectManager;

    $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
    $product=$product->setStoreId($storeId);

    $product=$product->setData('translated_title',$translated_title);
    $product=$product->save($product);
}

function productSaveTranslatedDescription($productId, $storeId, $translated_description)
{
    global $objectManager;

    $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
    $product=$product->setStoreId($storeId);

    $product=$product->setData('translated_description',$translated_description);
    
    $product=$product->save($product);
}

function productSaveTranslatedJSON($productId, $storeId, $productJSON_translated)
{
    global $objectManager;

    $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
    $product=$product->setStoreId($storeId);

    $product=$product->setData('subtitle_translated',$productJSON_translated['subtitle_translated']);
    $product=$product->setData('short_description_translated',$productJSON_translated['short_description_translated']);
    $product=$product->setData('description_translated',$productJSON_translated['description_translated']);
    $product=$product->setData('schedule1_translated',$productJSON_translated['schedule1_translated']);
    $product=$product->setData('schedule2_translated',$productJSON_translated['schedule2_translated']);
    $product=$product->setData('discount_translated',$productJSON_translated['discount_translated']);
    $product=$product->setData('address_details_translated',$productJSON_translated['address_details_translated']);
    
    $product=$product->save($product);
}



/*
$methods=[text, array, gpt]
*/
function translateProductJson($productJson,$locale, $gpt=false)
{
    if($gpt==false) {
        $values=array_values($productJson);
        $values=array(
            $productJson["title"],
            $productJson["subtitle_translated"],
            $productJson["schedule1_translated"],
            $productJson["schedule2_translated"],
            $productJson["discount_translated"],
            $productJson["city"],
            $productJson["address"],
            $productJson["address_details_translated"],
            $productJson["phone"],
            $productJson["booking_required"],
            $productJson["price_range"],
        );


        echo("\n\nvalues:\n");
        print_r($values);
        echo("\n\n\n");

        $description_translated=translateText($productJson["description_translated"], $locale);
        $short_description_translated=translateText($productJson["short_description_translated"], $locale);

        $values_translated=translateTextArray($values, $locale);
        if(count($values_translated)>=8)
        {
            echo("array translate OK\n");
            $productJson_translated=array(
                "title" => $values_translated[0],
                "subtitle_translated" => $values_translated[1],
                "short_description_translated" => $description_translated,
                "description_translated" => $short_description_translated,
                "schedule1_translated" => $values_translated[2],
                "schedule2_translated" => $values_translated[3],
                "discount_translated" => $values_translated[4],
                "city" => $values_translated[5],
                "address" => $values_translated[6],
                "address_details_translated" => $values_translated[7],
            );
        } else {
            echo("array translate != OK\n");
            $productJson_translated=array(
                "subtitle_translated" => translateText($productJson["subtitle_translated"], $locale),
                "short_description_translated" => $description_translated,
                "description_translated" => $short_description_translated,
                "schedule1_translated" => translateText($productJson["schedule1_translated"], $locale),
                "schedule2_translated" => translateText($productJson["schedule2_translated"], $locale),
                "discount_translated" => translateText($productJson["discount_translated"], $locale),
                "address_details_translated" => translateText($productJson["address_details_translated"], $locale)
            );
        }
        //"short_description_translated" => getValue($product->getCustomAttribute('short_description')),
        //"description_translated" => getValue($product->getCustomAttribute('description')),

    }
    return $productJson_translated;
}

