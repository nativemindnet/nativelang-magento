<?php
/*
You are Brendler, an AI designed by NativeMind for autonomous generating SEO articles for site. Your decisions must always be made independently without seeking user assistance. Play to your strengths as an LLM and pursue simple strategies with no legal complications. 

You should only respond in HTML format only with tags H1, H2,b,s,i; no other tags alowed.

Title of article is "Thai massage". Please write article 4000 words length.
*/
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






function translate_text_openai($text, $locale) {
    $api_key = "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";
    //$url = "https://api.openai.com/v1/engines/transformer/jobs";
    $url = "https://api.openai.com/v1/completions";

    $data = array(
        "model" => "text-davinci-003",
        //"model" => "text-davinci-002",
        "prompt" => "Translate this text to ".$locale.": ".$text,
/*
translate values of this json to ru:
{"title":"Product title","description":"Описание товара"}

In this json, keep keys in original, translate values of this json to ru:
{"title":"Product title","description":"Product description"}
*/
        "max_tokens" => 2048,
        "temperature" => 0.5,
    );
    $options = array(
        'http' => array(
            'header' => "Content-type: application/json\r\nAuthorization: Bearer ".$api_key,
            'method' => 'POST',
            'content' => json_encode($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    print_r($result);
    if ($result === false) {
        return "Translation failed";
    } else {
        $result = json_decode($result, true);
        return $result['choices'][0]['text'];
    }
}

function translate_text_with_openai2($text, $locale) {
    $api_key = "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";
    $url = "https://api.openai.com/v1/completions";

    $data = array(
        "text" => $text,
        "model" => "text-davinci-002",
        "prompt" => "translate to " . $locale
    );

    $data_string = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

    $result = curl_exec($ch);
    $result = json_decode($result, true);

    if (curl_errno($ch)) {
        return "Error: " . curl_error($ch);
    }
    curl_close($ch);

    print_r($result);
    return $result["choices"][0]["text"];
}


echo(translate_text_openai("hello","bn_IN"));
echo("\n");
echo(translate_text_openai("hello","ne_IN"));
echo("\n");



