<?php
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');



$storeIds=array(1,2,3,4,5,6,7,8,9,10,13,22,23,24,25,26,27,28,29,30,31,32,33);


//translateProducts(1);
translateCategories(2);


function translateCategories($rootCategoryId)
{
    global $objectManager;
    global $storeIds;

    $categoryCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
    $categories = $categoryCollection->create()
    ->addAttributeToSelect('name')
//    ->addFieldToFilter('level', ['gt' => 1])
//    ->addFieldToFilter('path', ['like' => "1/$rootCategoryId/%"])
    ->load();

    foreach ($categories as $category) {
        $categoryId=$category->getId();
        $categoryName=$category->getName();
        $categoryDescription=$category->getDescription();
        echo("categoryId=$categoryId\n");
        echo("categoryName=$categoryName\n");
        echo("categoryDescription=$categoryDescription\n");
	$act=$category->getIsActive();
	if ($act) echo("ACT");
        echo("parent_id={$category->getParentId()}\n");
        echo("storeId={$category->getStoreId()}\n");
        echo("storeId={$category->getDisplayMode()}\n");
        echo("storeId={$category->getIsAnchor()}\n");

	//print_r($category);
	continue;
        //$category->setName(translateToEnglish($category->getName()));
        //$category->save();

        
        foreach($storeIds as $storeId)
        {
            $locale=getLocale($storeId);
            echo("locale=$locale\n");
            $translatedName = translateText($categoryName, $locale);
            $translatedDescription = translateText($categoryDescription, $locale);
            categorySave($categoryId, $storeId, $translatedName ,$translatedDescription);
        }
    }
}


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
            productSave($productId, $storeId, $translatedName ,$translatedDescription);

            //$product=$product->setName($translatedName);
            //$product=$product->setDescription($translatedDescription);
            //$product=$product->save($product);
        }
    }
}


function getLocale($storeId)
{
    global $storeManager;
    $store = $storeManager->getStore($storeId);
    $locale = $store->getConfig('general/locale/code');
    //$locale=$product->getStore()->getConfig('general/locale/code');

    if($storeId==5) $locale="zh_CN";
    if($storeId==22) $locale="zh_TW";

    if($storeId==23) $locale="ta_IN";
    if($storeId==24) $locale="mr_IN";
    if($storeId==25) $locale="bn_IN";
    if($storeId==26) $locale="ne_IN";
    if($storeId==27) $locale="kn_IN";
    if($storeId==33) $locale="gu_IN";
    return $locale;
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

function categorySave($categoryId, $storeId, $name, $description)
{
    global $objectManager;
    //return;

    $category = $objectManager->create('Magento\Catalog\Model\Category')->load($categoryId);

    //$product->setName('New Product Name');
    //$product->save();

    $category=$category->setStoreId($storeId);
    $category=$category->setData('use_default_name',false);
    $category=$category->setData('use_default_description',false);
    if($name!="") $category=$category->setName($name);
    if($description!="") $category=$category->setDescription($description);
    $category=$category->save($category);
}

function translateText($text, $targetLanguage) {
    if($text=="") return"";
    return translateTextGoogle($text, $targetLanguage);
}

function translateTextGoogle($text, $targetLanguage) {
    
    // Add your Google Translate API Key here
    $apiKey = "AIzaSyBOti4mM-6x9WDnZIjIeyEU21OpBXqWBgw";

    // The source language is automatically detected
    $sourceLanguage = "auto";

    $text = urlencode($text);

    // Make a request to the Google Translate API
    //$response = file_get_contents("https://translation.googleapis.com/language/translate/v2?key=$apiKey&source=$sourceLanguage&target=$targetLanguage&q=$text");
    $response = file_get_contents("https://translation.googleapis.com/language/translate/v2?key=$apiKey&target=$targetLanguage&q=$text");
    //echo($response);
    $response = json_decode($response, true);
    //print_r($response);

    $res=$response['data']['translations'][0]['translatedText'];
    echo("translation=$res\n");
    return $res;
}