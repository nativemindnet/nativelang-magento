<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// phpcs:disable Magento2.Templates.ThisInTemplate.FoundThis

/**
 * Product description template
 *
 * @var $block \Magento\Catalog\Block\Product\View\Description
 */
?>
<?
    $product=$block->getProduct();
    $description=$product->getDescription();
    echo("<!--description:".$description."-->");
    $use_default=($product->getData('description')!=false);
    echo("<!--use_default:".$use_default."-->");
    $description_translated=$product->getData('description_translated');
    echo("<!--description_translated:".$description_translated."-->");

    if (($use_default == 1)&&($description_translated!="")) {
        $description=$description_translated;
    }
    echo("<!--description:".$description."-->");
?>
<?= /* @noEscape */ $this->helper(Magento\Catalog\Helper\Output::class)->productAttribute(
    $block->getProduct(),
    $description,
    'description'
) ?>
