Как работает Translations  для products.

В magento созданы для products отдельно аттрибуты translated_title, translated_description и т.д.

Есть скрипт translate_products.php который запускает перевод у продуктов.

Если use_default_value у translated_title==false, то значит уже переведено
force_translated - флаг запускать ли перевод повторно

??? Переводчик отталкивается от title в конкретном store_view ???

Дополнения наподобие address, schedule,...

name
description
subtitle?

address - не переводить (хотя например "рядом c Cikada Market")

facebook - не переводить
instagramm - не переводить






Далее что-то старое:

/bitnami/magento/vendor/magento/framework/Locale
Config.php