#Работа с БД

### В файле .env локальные настройки
Создать БД. Настроить подключение к базе данных в ``.env``. Изменить кодировку БД:
```sql
CREATE SCHEMA `poligon` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE ALTER SCHEMA `poligon`  DEFAULT COLLATE utf8_unicode_ci;
```
### Создаем миграции
```
php artisan make:migration create_users_table --create=users
```

### Создаем модели и миграции
```
php artisan make:model Models/BlogCategory -m
php artisan make:model Models/BlogPost -m
```
Artisan за нас сделает созданные миграции таблиц в множественном числе

Информация о миграциях:
https://laravel.com/docs/5.7/migrations

###Создание сидов
```
php artisan make:seeder UsersTableSeeder
php artisan make:seeder BlogCategoriesTableSeeder
```
### Запуска сидов
```
php artisan db:seed
php artisan db:seed --class=UsersTableSeeder
php artisan migrate:refresh --seed
```
Откат и накат - последняя операция

Если не запускаются сиды:
```
composer dumpautoload
```
###Документация на Faker
https://github.com/fzaninotto/Faker#fakerproviderimage

### Helpers
https://laravel.com/docs/7.x/helpers

##Контроллеры
###Создать REST контроллер
```
php artisan make:controller RestTestController --resource
```
### Необходимо определить роут
В файле: ```route/web.ph``` указать:
```php
Route::resource('rest', 'RestTestController')->names('restTest');
```

#### Просмотреть маршруты
```bash
php artisan route:list
```
####Контроллеры приложения
Базовый (родительский) контроллер блога:
```
php artisan make:controller Blog/BaseController
```
Базовый контроллер обязательный, т.к. может потребоваться для всех контроллеров
этой папки появиться одинаковые функциональности, и они будут описываться 
именно здесь.

Контроллер статей блога
```
php artisan make:controller Blog/PostController --resource
```
Ресурсный контроллер описывает RESTfull API, короче CRUD.

Не забывать добавлять роуты для вьюшек.

###Создание аутентификации
```
php artisan make:auth
php artisan migrate
```

### Модель
В модели есть трейт `SoftDeletes` для того чтоб убрать показывания 
мягко удаленных записей

Привязать в phpdoc данные о всех таблицах 
```
php artisan ide-helper:models
```

## Роутинг

```php
$groupData = [
    'namespace' => 'Blog\Admin',
    'prefix' => 'admin/blog',
];

Route::group($groupData, function () {
    //BlogCategory
    $methods = ['index', 'create', 'edit', 'store', 'update'];
    Route::resource('categories', 'CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');
});
```

### Создать объект запроса
```
php artisan make:request BlogCategoryUpdateRequest
```
