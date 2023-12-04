<?php

function translateTextGoogle_nocache($text, $targetLanguage) {
    
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

function translateTextGoogle($text, $targetLanguage) {
    // Генерируем уникальный ключ на основе MD5 от $system и $prompt
    $cache_key1 = "TEXT:".$text .";LANGUAGE:". $targetLanguage;
    //echo($cache_key1);
    $cache_key = md5($cache_key1);
    
    // Путь к файлу кеша
    $cache_dir = '/var/cache/portal/google/';
    $cache_file = $cache_dir . $cache_key . '.txt';

    // Проверяем, существует ли закешированный файл
    if (file_exists($cache_file)) {
        // Если файл существует, возвращаем его содержимое
        $cached=file_get_contents($cache_file);
        echo ("from cache:");
        echo ($cached);
        return $cached;
    } else {
        // Если файл не существует, обращаемся к серверу
        $result = translateTextGoogle_nocache($text, $targetLanguage);

        // Кешируем результат в файл
        file_put_contents($cache_file, $result);

        // Возвращаем результат
        return $result;
    }
}

//echo(translateTextGoogle("Hello","zh_CN"));
