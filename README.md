# Тестовое задание на позицию PHP-разработчика

- Реализован CRUD по ресурсу задачи (Task).
- Приложение запаковано в Docker (php-fpm + nginx + postgres), composer отдельным контейнером
- Добавлено тестирование через PHPUnit

## Запуск проекта

0. `mv ./src/env.example ./src/.env`
1. `docker compose up --build`
2. `docker compose run composer install`
3. `docker compose exec app bash`
4. `php artisan key:generate`
5. `php artisan migrate:fresh --seed`
6. `curl -XGET localhost:8000` (8000 - порт по умолчанию)

### Запуск тестов:

1. Убедитесь, что `database/testing.sqlite` существует, иначе создайте
2. `php artisan migrate:fresh --seed --env=testing`
3. `php artisan test`

---

### Как тестировалось:

- Postman + свои тесты
