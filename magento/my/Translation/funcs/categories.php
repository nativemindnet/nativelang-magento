<?php

function slugCategories($rootCategoryId,$minId)
{
    global $objectManager;
    global $storeIds;

    $categoryCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
    $categories = $categoryCollection->create()
    ->addAttributeToSelect('name')
    ->addFieldToFilter('level', ['gt' => 1])
    ->addFieldToFilter('path', ['like' => "1/$rootCategoryId/%"])
    ->load();

    foreach ($categories as $category) {
	$category->load($category->getId());
        $categoryId=$category->getId();
	if($categoryId<$minId) continue;
//    if($categoryId>$minId) continue;
        $categoryName=$category->getName();
        $categoryUrlKey=$category->getUrlKey();
        echo("categoryId=$categoryId\n");
        echo("categoryName=$categoryName\n");
        echo("categoryUrlKey=$categoryUrlKey\n");

        
        foreach($storeIds as $storeId)
        {
            $categoryStore = $objectManager->create('Magento\Catalog\Model\Category')->setStoreId($storeId)->load($categoryId);
            $categoryStoreName=$categoryStore->getName();
            echo("categoryStoreName=$categoryStoreName\n");

            $categoryUrlKey=slug($categoryStoreName);
            echo("categoryUrlKey=$categoryUrlKey\n");

            categoryUrlKeySave($categoryId, $storeId, $categoryUrlKey);
        }
    }
}


function translateCategories($rootCategoryId, $minId, $tr_desc=false, $force=false)
{
    global $objectManager;
    global $storeIds;

    $categoryCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
    $categories = $categoryCollection->create()
    ->addAttributeToSelect('name')
    ->addFieldToFilter('level', ['gt' => 1])
    ->addFieldToFilter('path', ['like' => "1/$rootCategoryId/%"])
    ->load();

    foreach ($categories as $category) {
	$category->load($category->getId());
    $categoryId=$category->getId();

	if($categoryId<$minId) continue;

        $categoryName=$category->getName();
        $categoryDescription=$category->getDescription();
        $categoryMetaTitle=$category->getMetaTitle();
        $categoryMetaDescription=$category->getMetaDescription();
        echo("categoryId=$categoryId\n");
        echo("categoryName=$categoryName\n");
        echo("categoryDescription=$categoryDescription\n");
        echo("categoryMetaTitle=$categoryMetaTitle\n");
        echo("categoryMetaDescription=$categoryMetaDescription\n");


        
        foreach($storeIds as $storeId)
        {
            $locale=getLocale($storeId);
            echo("locale=$locale\n");
            
            $categoryStore = $objectManager->create('Magento\Catalog\Model\Category')->setStoreId($storeId)->load($categoryId);

            $categoryStoreName=$categoryStore->getName();
            echo("categoryStoreName=$categoryStoreName\n");
            if($force||($categoryStoreName==$categoryName)||($categoryStoreName==""))
            {


                $translatedName = translateText($categoryName, $locale);
                if ($translatedName=="") 
                {
                    echo "NULL TRANSLATION";
                    continue;
                }
                $categoryStoreName=$translatedName;
            }

            $categoryStoreDescription=$categoryStore->getDescription();
            //echo("categoryStoreDescription=$categoryStoreDescription\n");

            if($tr_desc)
            {   
                if($force||($categoryStoreDescription==$categoryDescription)||($categoryStoreDescription==""))

                $translatedDescription = translateText($categoryDescription, $locale);
                //$translatedDescription =  generate_article($translatedName,$locale); 
                if ($translatedDescription=="") 
                {
                    echo "NULL TRANSLATION";
                    continue;
                }
                $categoryStoreDescription=$translatedDescription;
            }
            //$encodedCellData = '"' . str_replace(array('"', "\n"), array('""', "\\n"), $translatedDescription) . '"';

            
            //file_put_contents("cache/categories.txt", $locale.";;;".$categoryName.";;;".$translatedName.";;;".$encodedCellData."\n",FILE_APPEND);

            $translatedMetaTitle = translateText($categoryMetaTitle, $locale);
            $translatedMetaDescription = translateText($categoryMetaDescription, $locale);

            categorySave($categoryId, $storeId, $translatedName ,$translatedDescription,$translatedMetaTitle,$translatedMetaDescription);
        }
    }
}

function generateCategories($rootCategoryId, $minId, $force=false)
{
    global $objectManager;
    global $storeIds;

    $categoryCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
    $categories = $categoryCollection->create()
    ->addAttributeToSelect('name')
    ->addFieldToFilter('level', ['gt' => 1])
    ->addFieldToFilter('path', ['like' => "1/$rootCategoryId/%"])
    ->load();

    foreach ($categories as $category) {
	$category->load($category->getId());
        $categoryId=$category->getId();
	if($categoryId<$minId) continue;

        $categoryName=$category->getName();
        $categoryDescription=$category->getDescription();
        $categoryMetaTitle=$category->getMetaTitle();
        $categoryMetaDescription=$category->getMetaDescription();
        echo("-------");
        echo("categoryId=$categoryId\n");
        echo("categoryName=$categoryName\n");
        echo("categoryDescription=$categoryDescription\n");
        echo("categoryMetaTitle=$categoryMetaTitle\n");
        echo("categoryMetaDescription=$categoryMetaDescription\n");
        if($force || ($categoryDescription=="")) {

            $generatedDescription =  generate_article($categoryName,"en_US"); 
            if ($generatedDescription=="") 
            {
                echo "NULL GPT";
                continue;
            }
            echo($generatedDescription);
            $category->setDescription($generatedDescription);
            $category->save();
        }
        //$category->setName(translateToEnglish($category->getName()));
        //$category->save();

        /*
        foreach($storeIds as $storeId)
        {
            $locale=getLocale($storeId);
            echo("locale=$locale\n");
            $translatedName = translateText($categoryName, $locale);
            if ($translatedName=="") 
            {
                echo "NULL TRANSLATION";
                continue;
            }
            //$translatedDescription = translateText($categoryDescription, $locale);
            $translatedDescription =  generate_article($translatedName,$locale); 
            if ($translatedDescription=="") 
            {
                echo "NULL GPT";
                continue;
            }
            
            $encodedCellData = '"' . str_replace(array('"', "\n"), array('""', "\\n"), $translatedDescription) . '"';

            
            file_put_contents("cache/categories.txt", $locale.";;;".$categoryName.";;;".$translatedName.";;;".$encodedCellData."\n",FILE_APPEND);

            $translatedMetaTitle = translateText($categoryMetaTitle, $locale);
            $translatedMetaDescription = translateText($categoryMetaDescription, $locale);

            categorySave($categoryId, $storeId, $translatedName ,$translatedDescription,$translatedMetaTitle,$translatedMetaDescription);
        }
        */
        
    }
}

function categorySave($categoryId, $storeId, $name, $description,$metaTitle,$metaDescription)
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
    if($metaTitle!="") $category=$category->setMetaTitle($metaTitle);
    if($metaDescription!="") $category=$category->setMetaDescription($metaDescription);

    $category=$category->save($category);
}

function categoryUrlKeySave($categoryId, $storeId, $UrlKey)
{
    global $objectManager;
    $category = $objectManager->create('Magento\Catalog\Model\Category')->setStoreId($storeId)->load($categoryId);

    if($UrlKey!="") $category=$category->setUrlKey($UrlKey);
    try {
	$category=$category->save($category);
    } catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}