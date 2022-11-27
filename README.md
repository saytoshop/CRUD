# Задание 1. CRUD

Создать чистый проект на laravel, реализовать в нём следующий функционал

## Сущности

### Товары

- Поля: id, name, price

### Категории товаров

- Поля: id, name, parent_id
- Могут быть вложенными друг в друга, то есть иметь parent_id=id категории

## Методы

- GET `/categories` - получение категорий
- POST `/categories` - создание категории
- POST `/categories/{id}` - редактирование категории

- GET `/products` - получение списка товаров
- POST `/products` - создание товара
- POST `/products/{id}` - редактирование товара
- DELETE `/products/{id}` - удаление товара

- GET `/categories?includeProducts=1` - получение списка категорий c вложенными товарами
- GET `/categories/{id}?includeProducts=1` - получение одной категории c вложенными товарами
- GET `/categories/{id}/products` - получение списка товаров из категории
- GET `/categories/{id}/products?includeChildren=1` - получение списка товаров из категории и всех вложенных в неё категорий одним списком
