<?php

include("translateTextGoogle.php");

function translateText($text, $targetLanguage) {
    if($text=="") return"";
    return translateTextGoogle($text, $targetLanguage);
}

function getLocale($storeId)
{
    global $storeManager;
    $store = $storeManager->getStore($storeId);
    $locale = $store->getConfig('general/locale/code');
    //$locale=$product->getStore()->getConfig('general/locale/code');

    /*
    if($storeId==5) $locale="zh_CN";
    if($storeId==22) $locale="zh_TW";

    if($storeId==23) $locale="ta_IN";
    if($storeId==24) $locale="mr_IN";
    //if($storeId==25) $locale="bn_IN";
    if($storeId==26) $locale="ne_IN";
    if($storeId==27) $locale="kn_IN";
    if($storeId==33) $locale="gu_IN";*/
    return $locale;
}

