# Proyecto

## Instrucciones

Projecto en Laravel 8

1. Ejecutar
```
composer install
```
3. Generar .env (copiar el .env.example)
4. ejecutar 
```
php artisan key:generate
```
5. Crear base de datos
 - mysql --root u
 - create database todo_list

6. Dentro del archivo .env colocar DB_DATABASE=todo_list
7. Correr migraciones
```
php artisan migrate
```
9. Ejecutar el siguiente comando para guardar los archivos
```
php artisan storage:link
```
9. Ejecutar
```
php artisan serve
```
