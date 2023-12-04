<?php
include("translateText.php");
include("createGPT.php");



$filename = "titles_ru.txt";
$locales=array("en_US","ru_RU","hi_IN","th_TH","zh_Hans_CN","en_US","ko_KR","en_GB","pt_BR","th_TH","fr_FR","ru_RU","ru_RU","th_TH","hi_IN","de_DE","es_ES","vi_VN","ru_RU","en_GB","th_TH","ru_RU","th_TH","ar_SA","fi_FI","nl_NL","en_US","en_US","it_IT","ja_JP","pl_PL","ru_RU","en_US","ar_KW","sv_SE","bs_Latn_BA","sq_AL","zh_Hant_TW","bn_IN","ms_MY","id_ID");
/*
"en_US","ru_RU",
"hi_IN","th_TH","zh_Hans_CN","ko_KR","pt_BR","fr_FR","de_DE","es_ES",
"vi_VN","ar_SA","fi_FI","nl_NL","it_IT","ja_JP","pl_PL",
,"ar_KW","sv_SE","bs_Latn_BA","sq_AL","zh_Hant_TW",
"bn_IN","ms_MY","id_ID"
*/
$lines = file($filename);

foreach ($locales as $locale) {
    $n=0;
    foreach ($lines as $line) {
    $n++;
    echo("$n;".$line);
    $tr=translateText(($line),$locale);
    echo($tr);
    file_put_contents("res/titles.".$locale.".txt",$tr."\n", FILE_APPEND);
    
    $article =  generate_article($tr,$locale);
    file_put_contents("res/article.".$locale.".".$n.".txt",$article);
    //die();
}
}
