<?php

//Language list
//en	ru	uk	th	zh	ko	kn	es	fr	pt	ja	tr	vi	hi	ta	mr	bn	ne	he	ar
//English	Russian	Ukrainian	Thailand	Chinese	Korean	Kannada	Spanish	French	Portuguese	Japanese	Turkish	Vietnamese	Hindi	Tamil	Marathi	Bengali	Nepali	Hebrew	Arabic

/*
Thailand - branch stable(master) - основной - доступность 24x7, на продакшн сервере
Prepare -  stable(master) - для подготовки вывода новых локаций в основной Thailand - доступность 24x7, на продакшн сервере
Soon -  stable(master) - для SEO - доступность 24x7, на продакшн сервере

Admin -  stable(master) - для SEO - для администрирования, на продакшн сервере

new - branch new - проверка функционала dev перед merge с dev - может глючить, если не глючит - выводим в soon и thailand, на продакшн сервере
dev - branch dev - разработка ведется тут, вообще не гарантируется что он в онлайне, на тестовом серваке
*/


$domains2geo = array(
    'saijay.com' => 'th', // Thailand
    'saijay.net' => 'cn', // China
    'saijay.us' => 'us', // USA
    'saijay.in' => 'in', // India
    'saijay.ru' => 'ru', // Russia
);

$domains2spec = array(
    'admin.saijay.com' => 'view_huahin_en', // Magento Admin backend, by htpassword
    'blog.saijay.com' => 'end:domains2spec',  // Wordpress Admin backend, by htpassword, shoudn't get there
);

$folders2city = array (
    '' => 'huahin', //Hua Hin, Default
    'bangkok' => 'bangkok', //Bangkok
    'huahin' => 'huahin', //Hua Hin, copy just in case, shoudn't get there
    'chiangmai' => 'chiangmai', //Chiang Mai
    'phuket' => 'phuket', //Phuket
    'pattaya' => 'pattaya', //Pattaya
);

$folders2spec = array(
    'admin108' => 'end:folders2spec', // Magento Admin backend folder !end, т.к. должен заранее сработать по системному домену
    'blog' => 'end:folders2spec', //Wordpress, shoudn't get there
    'page' => 'end:folders2spec', // Tilda pages
    'tracker' => 'end:folders2spec', // Tracker for later
);


//$folder2view = array()
$domain2lang = array(
    //system:
    'admin.saijay.com'=>'en',

    //saijay.com:

    'saijay.com'=>'th',
    'th.saijay.com'=>'th', //Compatibility

    //seperate countries
    'en.saijay.com'=>'en',    
    'ru.saijay.com'=>'ru',

    //Europe
    'no.saijay.com'=>'no', // Norwegian
    'da.saijay.com'=>'da', // Danish
    'he.saijay.com'=>'he', // Hebrew

    'de.saijay.com'=>'de', // German
    'fr.saijay.com'=>'fr', // French
    'es.saijay.com'=>'es', // Spanish
    'it.saijay.com'=>'it', // Italian
    'sw.saijay.com'=>'sw', // Swedish
    'pl.saijay.com'=>'pl', // Polish
    
    'nl.saijay.com'=>'nl', // Dutch (Нидерладнский)
    'bs.saijay.com'=>'bs', // Bosnian / Боснийский
    'sq.saijay.com'=>'sq', // Albanian / Aлбанский
    'fi.saijay.com'=>'fi', // Finnish


    //Asia
    'vn.saijay.com'=>'vn', // Vietnamese / Вьетнамский
    'jp.saijay.com'=>'jp', // Japanese / Японский
    'ko.saijay.com'=>'ko', // Korean
    'id.saijay.com'=>'id', // Indonesian / Индонезийский
    'ms.saijay.com'=>'ms', // Malay / Малайский (Сингапур)

    //China
    'cn.saijay.com'=>'cn', // Chinese
    'tw.saijay.com'=>'tw', // Taiwanese

    'ar.saijay.com'=>'ar', // Арабский
    
    //India
    'hi.saijay.com'=>'hi', // Hindi
    'bn.saijay.com'=>'bn', // Bengali


    //seperate domains
    //saijay.us
    'saijay.us'=>'en',
    'th.saijay.us'=>'th',

    //saijay.ru
    'saijay.ru'=>'ru',
    'en.saijay.ru'=>'en',
    'th.saijay.ru'=>'th',

    //saijay.in
    'saijay.in'=>'hi',
    'bn.saijay.in'=>'bn',
    'en.saijay.in'=>'en',
    'th.saijay.in'=>'th',

    //saijay.net
    'saijay.net'=>'cn',
    'tw.saijay.net'=>'tw',
    'en.saijay.net'=>'en',
    'th.saijay.net'=>'th',
);


    
$alias2domain=array(
    //skip saijay.com
    //Без трафа, без контента, клеем сейчас, ссылки правильно расставим позже
    
    'getkumo.com' => 'saijay.net',
    'ahcichittagong.org' => 'bn.saijay.in',
    'jugosloveni.info' => 'bs.saijay.com',


    //С трафом, Без контента
    'healthbyhall.info' => 'sw.saijay.com',
    'elisting.info'=> 'hi.saijay.com',

    //С мало трафа с выключением основной
    'nsp81.info' => 'pl.saijay.com',
    'radiorog.info' => 'saijay.ru',

    'esaal.info' => 'ar.saijay.com',
    'gjeneralmegafoni.info' => 'sq.saijay.com', // Албанский
    //С средне трафа, с выключением основной
    'giaydabonghana.com' => 'vn.saijay.com',

    //Другие с контентом
    'milbuz.info' => 'saijay.ru', ///chiangmai
    'ipwe2023.info' => 'ml.saijay.com', //Малайский  ///chiangmai
    'asficlub.com' => 'id.saijay.com', //Индонезийский  ///chiangmai 
    
    //На город без контента
    'moskova.info' => 'fi.saijay.com',
    'bolognaonline.info' => 'it.saijay.com',
    'salnes.info' => 'jp.saijay.com',

    //На город с контентом
    'amsterdam-life.info' => 'nl.saijay.com', ///amsterdam
    'guercif.info/guercif' => 'ar.saijay.com/guercif',
);
