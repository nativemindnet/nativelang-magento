<?php
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('adminhtml');

$categoryFactory = $objectManager->create('Magento\Catalog\Model\CategoryFactory');

$categoryDataFile = fopen("categories.txt", "r") or die("Unable to open file!");


while(!feof($categoryDataFile)) {
    $categoryData = fgets($categoryDataFile);
    $categoryData = explode(',', $categoryData);

    // Check if the line is a valid category data
    if(count($categoryData) == 3) {
        try {
            // Load the parent category by name
            $parentCategory = $objectManager->create('Magento\Catalog\Model\Category')->loadByAttribute('name', trim($categoryData[2]));
	    if($parentCategory==false) 
		$parentCategoryId=69;
	    else 
		$parentCategoryId=$parentCategory->getId();

	    echo($parentCategoryId);
/*
	    $category = $objectManager->create('Magento\Catalog\Model\Category');
            $category->setName(trim($categoryData[0]));
            $category->setUrlKey(trim($categoryData[1]));
            $category->setIsActive(1);
            $category->setParentId($parentCategoryId);
//            $category->setStoreId(0);
            $category->save();
*/

    $line=$categoryData;

    $category = $categoryFactory->create();
    $category->setName($line[0]);
    $category->setUrlKey($line[1]);
    $category->setIsActive(1);
    $category->setIncludeInMenu(1);
    $category->setDisplayMode('PRODUCTS');
    $category->setIsAnchor(0);

    $parentCategoryName = $line[2];
    $parentCategory = $categoryFactory->create();
    //$parentCategoryId = $parentCategory->getCollection()->addFieldToFilter('name', $parentCategoryName)->getFirstItem()->getId();

    $category->setParentId($parentCategoryId);
    $category->save();


            echo "Category '" . $categoryData[0] . "' has been added successfully.\n";
        } catch (\Exception $e) {
            echo "Category '" . $categoryData[0] . "' could not be added. Error: " . $e->getMessage() . "\n";
        }
    }
}
fclose($categoryDataFile);