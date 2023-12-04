Как работает Translations  для products.

В magento созданы для products отдельно аттрибуты translated_title, translated_description и т.д.

Есть скрипт translate_products.php который запускает перевод у продуктов.

Если use_default_value у translated_title==false, то значит уже переведено
force_translated - флаг запускать ли перевод повторно

??? Переводчик отталкивается от title в конкретном store_view ???


Далее что-то старое:

/bitnami/magento/vendor/magento/framework/Locale
Config.php