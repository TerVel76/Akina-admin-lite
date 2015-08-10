# Akina-admin-lite
Akina Admin Panel

для проекта Скрипт фотохостинга "Akina"
http://akina-photohost.org/
https://github.com/vla7/akina/
https://code.google.com/p/akina/

При первом входе пароль записан в открытом виде в файл working/config.ini
Повторное обращение шифрует пароль.
Для "сброса" пароля удалить  working/config.ini

Реализованный функционал:
- Предпросмотр картинок в каталогах img/ (и thumbs/)
- Удаление картинок из каталогов img/ (и thumbs/)
- Удаление полкаталогов в каталогах img/ (и thumbs/)
- Просмотр текущих настроек.
- Смена пароля доступа к Admin Panel

Утсановка:
скопировать скрипт adm.php и папку admin в каталог с установленным фотохостингом Akina (рядом с index.php и config.php)
