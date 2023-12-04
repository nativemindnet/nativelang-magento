Как работает Translations  для products.

В magento созданы для products отдельно аттрибуты translated_title, translated_description и т.д.

Есть скрипт translate_products.php который запускает перевод у продуктов.

Если use_default_value у translated_title==false, то значит уже переведено
force_translated - флаг запускать ли перевод повторно

2 типа переводов: Через подмену в плагине, отображение сразу переведенного?

Отображение через подмену в плагине делается по следующему алгоритму: в приоритете до первого сработавшего:
1. Если существует заданное с use_default_value!=false, то отображается именно оно
2. Если существует перевод, то отображается именно он (перевод делается всегда именно от оригинальноно у website, не от кастомного storeview)
3. Отображается оригинал website_view

??? Переводчик отталкивается от title в конкретном store_view ???

Список аттрибутов:

Product Name -либо название место либо "Приходите в НАЗВАНИЕ МЕСТА" либо "Скидка в " (translated_name=Translated Product Name), отображение через подмену в плагине
short_description - переводить short_description_translated, отображение через подмену в плагине
description - переводить translated_description, отображение через подмену в плагине

Итого 3: name_translated, short_description_translated,description_translated  - отображение через подмену в плагине


subtitle_translated
schedule1_translated
schedule2_translated
address_details_translated
discount_translated

title - название места в оригинале (не переводится!!!, нет кастомного у store view)
subtitle - переводить subtitle_translated, отображается именно translated_subtitle


address - не переводить (нет кастомных store view)
address_details - уточнение - переводить address_details_translated например "рядом c Cikada Market"

facebook - не переводить
instagramm - не переводить





example page 30
пример - смотри example_translation.json

                                                                                                                       			








Далее что-то старое:

/bitnami/magento/vendor/magento/framework/Locale
Config.php