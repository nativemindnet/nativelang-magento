<?php

include("translateTextGoogle.php");

function translateText($text, $targetLanguage) {
    if($text=="") return"";
    return translateTextGoogle($text, $targetLanguage);
}

function translateTextArray($array,$locale)
{
    $debug=false;

    $text=json_encode($array);
    $values_json=htmlentities($text);
    //htmlentities <-> html_entity_decode
    if($debug) {
        echo("\n\nvalues_json:\n");
        print_r($values_json);
        echo("\n\n\n");
    }
    $values_json_translated=translateText($values_json, $locale);
    if($debug) {
        echo("\n\n!!!!!\nvalues_json_translated:\n");
        print_r($values_json_translated);
        echo("\n\n\n");
    }
    
    $values_json_translated_replaced=str_replace(",”",'&quot;,&quot;',$values_json_translated);
    if($debug) {
        echo("\n\n\values_json_translated_replaced:\n");
        print_r($values_json_translated_replaced);
        echo("\n\n\n");
    }
    
    $values_json_translated_decoded=html_entity_decode($values_json_translated_replaced);
    if($debug) {
        echo("\n\n\values_json_translated_decoded:\n");
        print_r($values_json_translated_decoded);
        echo("\n\n\n");
    }

    $values_translated=json_decode($values_json_translated_decoded);
    if($debug) {
        echo("\n\n\values_translated:\n");
        print_r($values_translated);
        echo("\n\n\n");
    }
    return $values_translated;
}

function translateTextArrayBeta($array,$locale)
{
    $text="&#91;".trim(json_encode($array),"[]")."&#93;";
    $values_json=htmlentities($text);
    //htmlentities <-> html_entity_decode
    echo("\n\nvalues_json:\n");
    print_r($values_json);
    echo("\n\n\n");
    $values_json_translated=translateText($values_json, $locale);
    echo("\n\n!!!!!\nvalues_json_translated:\n");
    print_r($values_json_translated);
    echo("\n\n\n");
    
    $values_json_translated_replaced=str_replace(",”",'&quot;,&quot;',$values_json_translated);
    echo("\n\n\values_json_translated_replaced:\n");
    print_r($values_json_translated_replaced);
    echo("\n\n\n");

    
    $values_json_translated_decoded=html_entity_decode($values_json_translated_replaced);
    echo("\n\n\values_json_translated_decoded:\n");
    print_r($values_json_translated_decoded);
    echo("\n\n\n");

    $values_translated=json_decode("[".$values_json_translated_decoded."]");
    echo("\n\n\values_translated:\n");
    print_r($values_translated);
    echo("\n\n\n");
    return $values_translated;
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

