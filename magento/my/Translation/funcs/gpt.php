<?php
include("keys.php");

function get_gpt_nocache($system, $prompt, $model, $max_tokens, $temperature) {
    echo("^G^");
    global $OPENAI_KEY;
    $url = "https://api.openai.com/v1/chat/completions";

    $data = array(
        //"model" => "gpt-3.5-turbo",
        //"model" => "gpt-3.5-turbo-16k-0613",
        "model" => $model,
        "messages" => array(
            array("role" => "system", "content"=> $system),
            array("role" => "user", "content"=> $prompt)
        ),
        "max_tokens" => $max_tokens,
        //"max_tokens" => 204, //test
        //"max_tokens" => 2048, 
        //"max_tokens" => 16000, //MAX
        //"temperature" => 0.7,
        //"temperature" => 1,
        "temperature" => $temperature,
    );
    $options = array(
        'http' => array(
            'header' => "Content-type: application/json\r\nAuthorization: Bearer ".$OPENAI_KEY,
            'method' => 'POST',
            'content' => json_encode($data),
            'timeout' => 6000, 
        )
    );
    $context = stream_context_create($options);

    print_r($data);
    print_r($options);


    $result = file_get_contents($url, false, $context);
    
    

    if ($result === false) {
        //echo(error_get_last()['message']);
        $error = error_get_last();
        if (strpos($error['message'], '429 Too Many Requests') !== false) {
            echo "Код ошибки 429: Too Many Requests";
            sleep(120);echo("sellep(120)");
        } else {
            echo "Другая ошибка: " . $error['message'];
            sleep(30);echo("sellep(30)");
        }


        return "";
    } else {
        $result = json_decode($result, true);
        reitn_r($result);
        return $result['choices'][0]['message']['content'];
    }
}


function get_gpt_cachefile($system, $prompt, $model, $max_tokens, $temperature) {
    // Генерируем уникальный ключ на основе MD5 от $system и $prompt
    $cache_key1 = "SYSTEM:".$system .";PROMPT:". $prompt.";MAXTOKENS:".$max_tokens.";TEMPERATURE:".$temperature.";MODEL:".$model;
    //echo($cache_key1);
    $cache_key = md5($cache_key1);
    
    // Путь к файлу кеша
    $cache_dir = 'cache/gpt/';
    $cache_file = $cache_dir . $cache_key . '.txt';
    return $cache_file;
}


function get_gpt_cache($system, $prompt, $model, $max_tokens, $temperature) {
    $cache_file=get_gpt_cachefile($system, $prompt, $model, $max_tokens, $temperature);

    // Проверяем, существует ли закешированный файл
    if (file_exists($cache_file)) {
        // Если файл существует, возвращаем его содержимое
        return file_get_contents($cache_file);
    }
    return "";
}


function get_gpt_params($system, $prompt, $model, $max_tokens, $temperature) {
    $cache=get_gpt_cache($system, $prompt, $model, $max_tokens, $temperature);
    if($cache!="") {
        return $cache;
    } else {
        // Если файл не существует, обращаемся к серверу
        $result = get_gpt_nocache($system, $prompt, $model, $max_tokens, $temperature);

        // Кешируем результат в файл
        $cache_file=get_gpt_cachefile($system, $prompt, $model, $max_tokens, $temperature);
        if($result!="") file_put_contents($cache_file, $result);

        // Возвращаем результат
        return $result;
    }
}


function get_gpt($system, $prompt, $max_tokens) {
    //curl https://api.openai.com/v1/models -H "Authorization: Bearer sk-"
    /*
      "id": "gpt-3.5-turbo-instruct-0914",
      "id": "gpt-3.5-turbo-instruct",
      "id": "gpt-3.5-turbo-0613",
      "id": "gpt-3.5-turbo",
      "id": "gpt-3.5-turbo-0301",
      "id": "gpt-3.5-turbo-16k",
      "id": "gpt-3.5-turbo-16k-0613",
    */
    //$model="gpt-3.5-turbo-16k";
    $model="gpt-3.5-turbo-16k";
    //$temperature=1;
    $temperature=0.7;
    $r1=get_gpt_cache($system, $prompt, $model, $max_tokens, $temperature);
    if ($r1!="") return $r1;
    
/*
    $max_tokens=6000;
    $model="gpt-4-0314";
    $temperature=1;
    $r2=get_gpt_params($system, $prompt, $model, $max_tokens, $temperature);
    if ($r2!="") return $r2;
    
    
    $max_tokens=14000;
    $model="gpt-3.5-turbo-16k";
    $temperature=0.7;
    $r3=get_gpt_params($system, $prompt, $model, $max_tokens, $temperature);
    return $r3;
    if ($r3!="") return $r3;
*/

$max_tokens=3000;
$model="gpt-3.5-turbo-0301";
$temperature=1;
$r4=get_gpt_params($system, $prompt, $model, $max_tokens, $temperature);
return $r4;
if ($r4!="") return $r4;
}

function get_gpt2($system, $prompt, $max_tokens) {
    //curl https://api.openai.com/v1/models -H "Authorization: Bearer sk-"
    /*
      "id": "gpt-3.5-turbo-instruct-0914",
      "id": "gpt-3.5-turbo-instruct",
      "id": "gpt-3.5-turbo-0613",
      "id": "gpt-3.5-turbo",
      "id": "gpt-3.5-turbo-0301",
      "id": "gpt-3.5-turbo-16k",
      "id": "gpt-3.5-turbo-16k-0613",
    */
    //$model="gpt-3.5-turbo-16k";
    $model="gpt-3.5-turbo-16k";
    //$temperature=1;
    $temperature=0.7;
    $r1=get_gpt_cache($system, $prompt, $model, $max_tokens, $temperature);
    //if ($r1!="") 
    return $r1;
    /*
    $max_tokens=3000;
    $model="gpt-3.5-turbo";
    $temperature=1;
    $r2=get_gpt_params($system, $prompt, $model, $max_tokens, $temperature);
    if ($r2!="") return $r2;
    */
    
    $max_tokens=14000;
    $model="gpt-3.5-turbo-16k";
    $temperature=1;
    $r3=get_gpt_params($system, $prompt, $model, $max_tokens, $temperature);
    return $r3;
    //if ($r3!="") return $r3;

}
//echo(get_gpt("","Hello",200));




/*
     "id": "text-search-babbage-doc-001",
          "id": "modelperm-s9n5HnzbtVn7kNc5TIZWiCFS",
      "id": "curie-search-query",
          "id": "modelperm-8aqdyZaKtD3MD831mGbqh1MD",
      "id": "text-search-babbage-query-001",
          "id": "modelperm-hXsRH2IK0hXmWxmLRiNTp70t",
      "id": "babbage",
          "id": "modelperm-h574xGeqWyBeFDDKaoVTC4CO",
      "id": "gpt-3.5-turbo-instruct-0914",
          "id": "modelperm-bZujHRhYVSFDYCfpD26EVHnA",
      "id": "babbage-search-query",
          "id": "modelperm-1zMLcaRlTvYAdpmvvixnTWlF",
      "id": "text-babbage-001",
          "id": "modelperm-YABzYWjC1kS6M2BnI6Fr9vuS",
      "id": "text-similarity-davinci-001",
          "id": "modelperm-C6TT4mQR3bJQEzEuiZlhKM5u",
      "id": "davinci",
          "id": "modelperm-RcfCH2MkO5NP9C7wx6kdYnIT",
      "id": "davinci-similarity",
          "id": "modelperm-OtRWxI0nRtN9q8mHI3OOk0GT",
      "id": "code-davinci-edit-001",
          "id": "modelperm-T8Ie7SvlPyvtsDvPlfC8DftZ",
      "id": "curie-similarity",
          "id": "modelperm-9PfIlYDKOt24EV6fnCiunZGA",
      "id": "babbage-search-document",
          "id": "modelperm-qJ0Iu5XcwrdsmSOn9ewphBNF",
      "id": "curie-instruct-beta",
          "id": "modelperm-rTxpdy2DwwUp38frYQFsj5OC",
      "id": "text-search-ada-doc-001",
          "id": "modelperm-tdL3cX2rMgQuyfQwqNGcQOp3",
      "id": "davinci-instruct-beta",
          "id": "modelperm-SKEW42qz05X43sqLXFwhbAox",
      "id": "text-similarity-babbage-001",
          "id": "modelperm-yNsfFUtfAoDhJHRofgD2Kjgd",
      "id": "text-search-davinci-doc-001",
          "id": "modelperm-I0hY9ySAeJrE3qBF47roClh9",
      "id": "babbage-similarity",
          "id": "modelperm-8Inp4vh9P5Mh0llHmSX8Va3b",
      "id": "davinci-search-query",
          "id": "modelperm-ZNL7KVorrZk5pvj7v3cG3lUz",
      "id": "text-similarity-curie-001",
          "id": "modelperm-J2U414W9ZcjxYqf13tZdvwI5",
      "id": "text-davinci-001",
          "id": "modelperm-bwpDudS41UaZskP1jKfAHKMG",
      "id": "text-search-davinci-query-001",
          "id": "modelperm-lEI8RY9UBNhXYJRKub8U4Sc1",
      "id": "ada-search-document",
          "id": "modelperm-CSgBXBOV02tB05EbOK36apFu",
      "id": "ada-code-search-code",
          "id": "modelperm-NFpO3yF5OZ9bfwls2MSUn5cR",
      "id": "babbage-002",
          "id": "modelperm-tC8uL3ohDEVSzUvcgZCv33gV",
      "id": "davinci-002",
          "id": "modelperm-9a6yBfznsbObxHVWBWRJctsx",
      "id": "davinci-search-document",
          "id": "modelperm-Bbb0MBYeWROhvx9NkaDbZg3R",
      "id": "curie-search-document",
          "id": "modelperm-xkoHDxWoBlLQj4HM4iVwWj9C",
      "id": "babbage-code-search-code",
          "id": "modelperm-5Dv3knU1yoRtpY5TFzSHySiM",
      "id": "text-search-ada-query-001",
          "id": "modelperm-2XH9mphBxBD5uKyXKn8o77sE",
      "id": "code-search-ada-text-001",
          "id": "modelperm-MQOFciXDRywliXymhKJT5rUy",
      "id": "babbage-code-search-text",
          "id": "modelperm-DE4WMTkago3EHJ0n1p2urLkw",
      "id": "code-search-babbage-code-001",
          "id": "modelperm-xuS8vuaSaa5jIQSmyP0S35Qd",
      "id": "ada-search-query",
          "id": "modelperm-kSLKiCrDbosTMvZnIt5wuEqE",
      "id": "ada-code-search-text",
          "id": "modelperm-Ya8bDcPgbFbqFR0K44jdPN64",
      "id": "text-search-curie-query-001",
          "id": "modelperm-7Y7YYZkPezf96wy8j5bphjjg",
      "id": "text-davinci-002",
          "id": "modelperm-eKMXF4rV1slbvrpgmDbTm3wD",
      "id": "text-embedding-ada-002",
          "id": "modelperm-iHRhxPwYPqj6AJE3PFzga9rD",
      "id": "text-davinci-edit-001",
          "id": "modelperm-bwEWUtGiBcdX0p1D1ayafH8w",
      "id": "code-search-babbage-text-001",
          "id": "modelperm-JkzgCs0oPZaC1uCfO0n0ulYX",
      "id": "ada",
          "id": "modelperm-0JnkYlxDvw3kMS1mht3cmQKR",
      "id": "whisper-1",
          "id": "modelperm-Hka8rEQIgc19qbNrKUogNrX3",
      "id": "gpt-4-0613",
          "id": "modelperm-06WdiRJI7hDMqoovdhXaJfTE",
      "id": "text-ada-001",
          "id": "modelperm-jRuB7xBCdj159SqaDmpPgeWO",
      "id": "ada-similarity",
          "id": "modelperm-z4NZ5sCV2GsxBeNqzcNVhEvH",
      "id": "code-search-ada-code-001",
          "id": "modelperm-9k7jVGlzTgB52nza3Po7ENUZ",
      "id": "gpt-4",
          "id": "modelperm-YlTTKPw2rM1Gnt288SU4lYr0",
      "id": "text-similarity-ada-001",
          "id": "modelperm-2l92GeLtllKOhDdWb6RzzfEN",
      "id": "gpt-3.5-turbo-0301",
          "id": "modelperm-I4IcSJFYZl2fIK0DPSBkgK3d",
      "id": "gpt-3.5-turbo-16k",
          "id": "modelperm-ws4f4bZHZRiHC2iI0emxIa4z",
      "id": "text-search-curie-doc-001",
          "id": "modelperm-gMoCj5Vfel451hGbAp0kfKMH",
      "id": "gpt-3.5-turbo-16k-0613",
          "id": "modelperm-Hk9J34s4hlEGFpmvYhhEdeso",
      "id": "text-davinci-003",
          "id": "modelperm-OLYlW6I3e7VURS85ytehLxKj",
      "id": "text-curie-001",
          "id": "modelperm-3D7myCVeMXS00PJdPESttrwj",
      "id": "gpt-3.5-turbo",
          "id": "modelperm-WVAcp6bvsxmZVeiS0E4BE5pf",
      "id": "curie",
          "id": "modelperm-FwPnxb7Y7YHn9eMwTNgQyiJ4",
      "id": "gpt-3.5-turbo-0613",
          "id": "modelperm-iuFYjXFXGB6Rauz5bjWKSm7v",
      "id": "gpt-4-0314",
          "id": "modelperm-uAZYNOQTI3UZMxYcK6iftTii",
      "id": "gpt-3.5-turbo-instruct",
          "id": "modelperm-2IwUgbROXwGFTqPydUGXkB3x",
*/