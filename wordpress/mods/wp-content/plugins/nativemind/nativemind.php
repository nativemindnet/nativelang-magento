<?php
/**
 * Plugin Name: NativeMind Plugin
 * Description: NativeMind plugin to handle post translations and other functions.
 * Version: 1.0
 * Author: NativeMind.net (Anton Dodonov)
 */

// Подключение файла функций
include_once plugin_dir_path( __FILE__ ) . 'include/functions.php';

// Подключение файла переводов
include_once plugin_dir_path( __FILE__ ) . 'include/translations.php';

class NativeMind {
    public function __construct() {
        add_filter('the_content', array($this, 'handle_post_translation'));
    }

    public function handle_post_translation($content) {
        return my_custom_translation_logic($content);
    }
}

// Инициализация плагина
$native_mind = new NativeMind();