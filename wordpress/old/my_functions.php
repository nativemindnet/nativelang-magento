<?php
/*
function my_custom_language_routing() {
    // Установите текущий и дефолтный языки
    $current_language = pll_current_language(); // Получение текущего языка через Polylang
    $default_language = pll_default_language(); // Получение дефолтного языка через Polylang

    //$current_language = 'ru'; // Например, русский
    //$default_language = 'en'; // Например, английский

    // Получите ID текущего поста
    $post_id = get_the_ID();

    // Проверьте, есть ли перевод для текущего языка
    if (!pll_get_post($post_id, $current_language)) {
        // Получите ID поста на дефолтном языке
        $default_language_post_id = pll_get_post($post_id, $default_language);

        // Загрузите пост на дефолтном языке, если он существует
        if ($default_language_post_id) {
            $GLOBALS['post'] = get_post($default_language_post_id); // Установите глобальную переменную $post
            setup_postdata($GLOBALS['post']); // Установите данные поста
        }
    }
}

add_action('template_redirect', 'my_custom_language_routing');



function add_custom_text_to_content($content) {
    // Установите текущий и дефолтный языки
    $current_language = pll_current_language(); // Получение текущего языка через Polylang
    $default_language = pll_default_language(); // Получение дефолтного языка через Polylang

    // Получите ID текущего поста
    $post_id = get_the_ID();

    
    // Проверьте, есть ли перевод для текущего языка
    if (!pll_get_post($post_id, $current_language) && $current_language !== $default_language) {
        // Кастомный текст
        $custom_text = '<p>Sorry, translation only on default language.</p>';

        // Добавьте кастомный текст в начало контента
        $content = $custom_text . $content;
    }

    return $content;
}

add_filter('the_content', 'add_custom_text_to_content');
*/
require("my_translation.php")