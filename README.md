Запуск проекта:
```
docker compose -f /testNovex/compose.yaml -p testnovex up -d
```

Миграция:
```
docker exec -it testnovex-php-fpm-1 bash
php bin/console doctrine:migrations:migrate
```

Заполнение тестовыми данными:
```
php bin/console doctrine:fixtures:load
```
