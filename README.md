# О приложении

Техническое задание от университета

## Что реализовано?

-   Авторизация
-   Регистрация
-   Изменение данных
-   Генерация пароля и хранение его в зашифрованном виде в БД

## Что я использовал?

-   PHP
-   Laravel
-   PostgreSQL
-   Javascript
-   SASS

## Что планирую сделать?

-   Работа с постами
-   Подписки на профили
-   Админка

## Как запустить?

### Установить пакеты

```bash
composer install
```

```bash
npm install
```

### Также вы должны создать БД

```sql
CREATE DATABASE name_db;
```

### .env файл должен содержать следующие параметры

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=name_db
DB_USERNAME=postgres
DB_PASSWORD=

JWT_KEY=""
```

### Запустить миграции

```bash
php artisan migrate
```

### Запустить проект

```bash
php artisan serve
```

```bash
npm run dev
```

## Фотографии проекта

![view application](https://sun9-23.userapi.com/impg/mm2m9VGVUFR8ys6ovWnqsPwD2GK9Zin_H0kNGQ/m4Ks8cGOghI.jpg?size=1463x819&quality=96&sign=3efe61ab7492254df02a2e2c08e4ad3c&type=album)
![view application](https://sun9-19.userapi.com/impg/Al3cPHkXJkn_5oE1zoKMfP_VWe3JgmisznyNfg/ibkRozX1iD8.jpg?size=1920x1080&quality=96&sign=d92095b2850e745b27596a9ebaf3d9e7&type=album)
![view application](https://sun7-13.userapi.com/impg/pVEbPtv8OozrBIqMZ9fkdOoB4hEyhOxZtUCpJg/xiZs8Kb_D-I.jpg?size=1459x822&quality=96&sign=4009d9021b56975dd4abf34ae6c5c3b3&type=album)
![view application](https://sun7-24.userapi.com/impg/vzzbFdsgKAIzqTdQKNyhAQY6LfshhreDMYjxLg/gEMG_1dSD6c.jpg?size=1463x823&quality=95&sign=95e276ba697b1fb09d15c1ded34829bb&c_uniq_tag=sOmq2ELyRHFrOTOJZfQY0YkRlllddmo2jV0OJ8TDWt0&type=album)
![view application](https://sun9-66.userapi.com/impg/GhB25SBwwKvUCthujEqX-zsfMnqmTAnkrvsRdQ/t0nY9iFtTro.jpg?size=1463x823&quality=95&sign=db4a0b5d1ada40fe5b9966142a9d04e8&c_uniq_tag=3hRL-H5YL6gRdf0YOlYPID0ZgDIVhdbTPV6TCDRi5W4&type=album)
