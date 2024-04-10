## Основное
### Запуск проекта:
```
docker compose -f /testNovex/compose.yaml -p testnovex up -d
```

### Миграция:
```
docker exec -it testnovex-php-fpm-1 bash
php bin/console doctrine:migrations:migrate
```

### Заполнение тестовыми данными:
```
php bin/console doctrine:fixtures:load
```

## API
### Show
Возвращает JSON с данными пользователя по ID.

**GET**
```
/api/users/show?id={ID}
```
### List
Возвращает JSON с данными всех пользователей. 

**GET**
```
/api/users/list
```
### Create
Создает пользователя. Принимает JSON, возвращает JSON с данными пользователя.

```
{
    "birthday": "1959-05-20",
    "phone": "+79267174446",
    "sex": "male",
    "name": "Иван Иванов",
    "email": "ivan.ivanov@gmail.com"
}
```
**POST**
```
/api/users/create
```

**Ответ:**

```
{
    "birthday": "1959-05-20",
    "phone": "+79267174446",
    "sex": "male",
    "age": 64,
    "name": "Иван Иванов",
    "email": "ivan.ivanov@gmail.com",
    "id": 1
}
```
### Update
Обновляет пользователя. Принимает JSON, возвращает JSON с данными пользователя.

```
{
    "birthday": "1958-05-20",
    "phone": "+79267174446",
    "sex": "male",
    "name": "Иван Иванов",
    "email": "ivan.ivanov@gmail.com"
}
```

**POST**
```
/api/users/update
```

**Ответ:**

```
{
    "birthday": "1958-05-20",
    "phone": "+79267174446",
    "sex": "male",
    "age": 65,
    "name": "Иван Иванов",
    "email": "ivan.ivanov@gmail.com",
    "id": 1
}
```
### Delete
Удаляет пользователя. Принимает JSON  с ID пользователя.

```
{
    "id": 1
}
```

**POST**
```
/api/users/delete
```
