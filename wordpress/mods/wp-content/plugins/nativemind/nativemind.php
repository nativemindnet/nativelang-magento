<?php
/**
 * Plugin Name: NativeMind Plugin
 * Description: NativeMind plugin to handle post translations and other functions.
 * Version: 1.0
 * Author: NativeMind.net (Anton Dodonov)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Don't access directly.
};

// Подключение файла функций
//include_once __DIR__ . 'include/functions.php';

// Подключение файла переводов
//include_once __DIR__ . 'include/translations.php';
require "translateTextGoogle.php";

class NativeMind {
    public function __construct() {
/*
        if (is_plugin_active('polylang/polylang.php')) {
            // Ваш код
        }
*/
        add_filter('the_content', array($this, 'handle_post_translation'));
        // Добавление фильтра для элементов меню
        add_filter('wp_get_nav_menu_items', array($this, 'translate_menu_items'), 20, 3);
    }

    public function translate_menu_items($items, $menu, $args) {
        foreach ($items as &$item) {
            // Проверяем, является ли элемент категорией
	    $current_language=pll_current_language();
	    if ($item->title == "#LANGUAGE#")
	    {
		//$item->title=$current_language;
		$languages = pll_the_languages(array('raw' => 1)); // Получаем список языков
		$item->title=$languages[$current_language]["name"];
	    }
            if ($item->type === 'taxonomy' && $item->object === 'category') {
                // Пытаемся получить переведенное название категории
		//$category = get_term_by('id', $item->object_id, 'category');
		$category_id=$item->object_id;
		//$translated_title = $category_id;
		$translated_category_id = pll_get_term($category_id, $language_code);
                $translated_category = get_term_by('id', $translated_category_id , 'category');
                if ($translated_category && !is_wp_error($translated_category)) {
                    // Используем название категории
                    $item->title = $translated_category->name;
		}
                // Иначе оставляем название по умолчанию
            }
        }
        return $items;
    }


    public function handle_post_translation($content) {
        $post_id = get_the_ID();
    
        $current_language = pll_current_language();
        $default_language = pll_default_language();
    
        $original_path = "/var/tmp/original/{$post_id}.{$default_language}";
        $translated_path = "/var/tmp/translated/{$post_id}.{$current_language}";
    
    
        // Если пост существует, сохраняем его в оригинальной папке
        if (pll_get_post($post_id, $default_language)) {
            $post = get_post($post_id);
        $content=$post->post_content;
        }

        file_put_contents($original_path, $content);

	//return("TEST".$content);

        // Проверяем, существует ли перевод
        if (file_exists($translated_path)) {
            return file_get_contents($translated_path);
        } else {
            // Здесь ваша логика перевода

            $translated_content = $this->translate($content, $default_language, $current_language);
            file_put_contents($translated_path, $translated_content);
            return $translated_content;
        }
    }

    
    // Функция перевода (примерная структура)
    function translate($content, $language_from, $language_to) {
        // Логика перевода
        // Возвращаем переведенный контент
	//return "TEST2";

	$content=translateTextGoogle_nocache($content,$language_to);
        return $content;
    }
}

// Инициализация плагина
$native_mind = new NativeMind();