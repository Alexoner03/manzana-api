#Requerimientos
-Php 8 <br>
-Mysql

#Instalación
- Composer install <br>
- cp .env.example .env
- setear variables de entorno
- php artisan key:generate
- php artisan jwt:generate
- php artisan migrate:fresh --seed
- php artisan serve

#Test

Solo se realizaron pruebas unitarias y de integración, las preubas e2e o de aceptación quedaron pendientes para la proxima

- php artisan test

