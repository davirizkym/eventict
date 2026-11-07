@echo off
cd /d "%~dp0public"
php -d extension=pdo_sqlite -d extension=sqlite3 -d extension=zip -S 127.0.0.1:8000 ../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php
