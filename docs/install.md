### ```Не забудь что все выполняется из под докера!!!```
#Установка
### Установка прав на папки (777)
```
sudo chmod 777 -R ./storage/ && chmod 777 -R ./bootstrap/cache/
```

### Установить плагин ``laravel`` в PhpStorm

### Установить ide-helper
```
composer require --dev barryvdh/laravel-ide-helper
```
В `composer.json` добавить:
```
"scripts":{
    "post-update-cmd": [
        "Illuminate\\Foundation\\ComposerScripts::postUpdate",
        "@php artisan ide-helper:generate",
        "@php artisan ide-helper:meta"
    ]
},
```
Обновить версии через композер `composer update`

###Установаить рабочие дириктории в PhpStorm
**app** - ***`source`***,
**tests**   - ***`tests`***,
**bootstrap/cache**   - ***`excludes`***,
**storage**   - ***`excludes`***,
**resources**   - ***`resources`***,

###Установать debugbar
```
composer require barryvdh/laravel-debugbar --dev
```
Убрать можно установив в ``.evn`` ```APP_DEBUG=false```

### Установить остальные плагины
Установить их в плагинах PhpStorm (найти все по laravel и все их установить). И ***активировать*** laravel plugin:
```
https://www.jetbrains.com/help/phpstorm/laravel.html
```